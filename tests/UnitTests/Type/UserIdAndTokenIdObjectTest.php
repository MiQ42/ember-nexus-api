<?php

declare(strict_types=1);

namespace App\Tests\UnitTests\Type;

use App\Type\UserIdAndTokenIdObject;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

#[Small]
#[CoversClass(UserIdAndTokenIdObject::class)]
class UserIdAndTokenIdObjectTest extends TestCase
{
    public function testUserIdAndTokenIdObject(): void
    {
        $userId1 = Uuid::fromString('09c8325c-4029-4c0a-93db-e695de6a6516');
        $userId2 = Uuid::fromString('bbc04d1f-bd5a-45c9-8633-5137788bef52');
        $tokenId1 = Uuid::fromString('335865b2-c42f-4c1a-a7bd-d7e8d3df40fb');
        $tokenId2 = Uuid::fromString('62e90895-2b86-4a87-8f82-a9d498a56053');

        $userIdAndTokenIdObject = new UserIdAndTokenIdObject(
            $userId1,
            $tokenId1
        );

        $this->assertSame($userId1, $userIdAndTokenIdObject->getUserId());
        $this->assertSame($tokenId1, $userIdAndTokenIdObject->getTokenId());

        $userIdAndTokenIdObject->setUserId($userId2);
        $userIdAndTokenIdObject->setTokenId($tokenId2);

        $this->assertSame($userId2, $userIdAndTokenIdObject->getUserId());
        $this->assertSame($tokenId2, $userIdAndTokenIdObject->getTokenId());
    }
}
