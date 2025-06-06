<?php

declare(strict_types=1);

namespace App\Controller\Element;

use App\Attribute\EndpointSupportsEtag;
use App\Factory\Exception\Client404NotFoundExceptionFactory;
use App\Helper\Regex;
use App\Security\AccessChecker;
use App\Security\AuthProvider;
use App\Service\CollectionService;
use App\Type\AccessType;
use App\Type\ElementType;
use App\Type\EtagType;
use Laudis\Neo4j\Databags\Statement;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Syndesi\CypherEntityManager\Type\EntityManager as CypherEntityManager;

class GetParentsController extends AbstractController
{
    public function __construct(
        private CypherEntityManager $cypherEntityManager,
        private CollectionService $collectionService,
        private AuthProvider $authProvider,
        private AccessChecker $accessChecker,
        private Client404NotFoundExceptionFactory $client404NotFoundExceptionFactory,
    ) {
    }

    #[Route(
        '/{id}/parents',
        name: 'get-parents',
        requirements: [
            'id' => Regex::UUID_V4_CONTROLLER,
        ],
        methods: ['GET']
    )]
    #[EndpointSupportsEtag(EtagType::PARENTS_COLLECTION)]
    public function getParents(string $id): Response
    {
        $childId = UuidV4::fromString($id);
        $userId = $this->authProvider->getUserId();

        $type = $this->accessChecker->getElementType($childId);
        if (ElementType::RELATION === $type) {
            // relations can not be child nodes
            throw $this->client404NotFoundExceptionFactory->createFromTemplate();
        }

        if (!$this->accessChecker->hasAccessToElement($userId, $childId, AccessType::READ)) {
            throw $this->client404NotFoundExceptionFactory->createFromTemplate();
        }

        $cypherClient = $this->cypherEntityManager->getClient();

        $res = $cypherClient->runStatement(Statement::create(
            "MATCH (user:User {id: \$userId})\n".
            "MATCH (child {id: \$childId})\n".
            "MATCH (child)<-[r:OWNS]-(parent)\n".
            "OPTIONAL MATCH path=(user)-[:IS_IN_GROUP*0..]->()-[:OWNS|HAS_READ_ACCESS*0..]->(parent)\n".
            "WHERE\n".
            "  user.id = parent.id\n".
            "  OR\n".
            "  ALL(relation in relationships(path) WHERE\n".
            "    type(relation) = \"IS_IN_GROUP\"\n".
            "    OR\n".
            "    type(relation) = \"OWNS\"\n".
            "    OR\n".
            "    (\n".
            "      type(relation) = \"HAS_READ_ACCESS\"\n".
            "      AND\n".
            "      (\n".
            "        relation.onLabel IS NULL\n".
            "        OR\n".
            "        relation.onLabel IN labels(parent)\n".
            "      )\n".
            "      AND\n".
            "      (\n".
            "        relation.onParentLabel IS NULL\n".
            "        OR\n".
            "        relation.onParentLabel IN labels(parent)\n".
            "      )\n".
            "      AND\n".
            "      (\n".
            "        relation.onState IS NULL\n".
            "        OR\n".
            "        (parent)<-[:OWNS*0..]-()-[:HAS_STATE]->(:State {id: relation.onState})\n".
            "      )\n".
            "      AND\n".
            "      (\n".
            "        relation.onCreatedByUser IS NULL\n".
            "        OR\n".
            "        (parent)<-[:CREATED_BY*]-(user)\n".
            "      )\n".
            "    )\n".
            "  )\n".
            "WITH user, r, parent, path\n".
            "ORDER BY parent.id, r.id\n".
            "WHERE\n".
            "  user.id = parent.id\n".
            "  OR\n".
            "  path IS NOT NULL\n".
            "WITH parent, collect(DISTINCT r.id) AS rCol\n".
            "WITH parent, collect(parent.id) + collect(rCol) AS row\n".
            "WITH collect(DISTINCT row) AS allRows, count(parent) AS totalCount\n".
            "UNWIND allRows AS row\n".
            "RETURN row[0] AS parent, row[1] AS r, totalCount\n".
            "ORDER BY parent\n".
            "SKIP \$skip\n".
            'LIMIT $limit',
            [
                'userId' => $userId->toString(),
                'childId' => $childId->toString(),
                'skip' => ($this->collectionService->getCurrentPage() - 1) * $this->collectionService->getPageSize(),
                'limit' => $this->collectionService->getPageSize(),
            ]
        ));
        $totalCount = 0;
        $nodeIds = [];
        $relationIds = [];
        if (count($res) > 0) {
            $totalCount = $res->first()->get('totalCount');
            foreach ($res as $resultSet) {
                $nodeIds[] = UuidV4::fromString($resultSet->get('parent'));
                foreach ($resultSet->get('r') as $relationId) {
                    $relationIds[] = UuidV4::fromString($relationId);
                }
            }
        }

        return $this->collectionService->buildCollectionFromIds($nodeIds, $relationIds, $totalCount);
    }
}
