<?php

declare(strict_types=1);

namespace App\Tests\UnitTests\Factory\Exception;

use App\Factory\Exception\Client401UnauthorizedExceptionFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Small]
#[CoversClass(Client401UnauthorizedExceptionFactory::class)]
class Client401UnauthorizedExceptionFactoryTest extends TestCase
{
    use ProphecyTrait;

    public function testCreateFromTemplate(): void
    {
        $urlGenerator = $this->prophesize(UrlGeneratorInterface::class);
        $urlGenerator->generate(
            Argument::is('exception-detail'),
            Argument::is([
                'code' => '401',
                'name' => 'unauthorized',
            ]),
            Argument::is(UrlGeneratorInterface::ABSOLUTE_URL)
        )->shouldBeCalledOnce()->willReturn('https://mock.dev/123');
        $factory = new Client401UnauthorizedExceptionFactory($urlGenerator->reveal());

        $exception = $factory->createFromTemplate();

        $this->assertSame(401, $exception->getStatus());
        $this->assertSame('Unauthorized', $exception->getTitle());
        $this->assertSame('https://mock.dev/123', $exception->getType());
        $this->assertSame("Authorization for the request failed due to possible problems with the token (incorrect or expired), password (incorrect or changed), the user's unique identifier, or the user's status (e.g., missing, blocked, or deleted).", $exception->getDetail());
        $this->assertSame(null, $exception->getInstance());
        $this->assertSame('', $exception->getMessage());
    }
}
