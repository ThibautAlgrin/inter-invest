<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Controller\DefaultController;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class DefaultControllerTest.
 *
 * @codingStandardsIgnoreFile
 *
 * @SuppressWarnings(PHPMD)
 */
class DefaultControllerTest extends TestCase
{
    /**
     * @var RouterInterface|MockObject
     */
    private $router;

    protected function setUp()
    {
        $this->router = $this->createMock(RouterInterface::class);
    }

    public function testShouldRedirectHomeToFirmList()
    {
        $this->router->expects($this->once())->method('generate')->with('firm_index')->willReturn('/firms');

        $controller = $this->getController();
        $this->assertInstanceOf(RedirectResponse::class, $controller->__invoke());
    }

    private function getController(): DefaultController
    {
        return new DefaultController($this->router);
    }
}
