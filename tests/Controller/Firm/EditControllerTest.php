<?php

declare(strict_types=1);

namespace App\Tests\Controller\Firm;

use App\Controller\Firm\EditController;
use App\Entity\Firm;
use App\Form\FirmType;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

/**
 * Class EditControllerTest.
 *
 * @codingStandardsIgnoreFile
 *
 * @SuppressWarnings(PHPMD)
 */
class EditControllerTest extends TestCase
{
    /**
     * @var Environment|MockObject
     */
    private $twig;

    /**
     * @var RouterInterface|MockObject
     */
    private $router;

    /**
     * @var FormFactoryInterface|MockObject
     */
    private $formFactory;

    /**
     * @var EntityManagerInterface|MockObject
     */
    private $em;

    /**
     * @var Request|MockObject
     */
    private $request;

    public function setUp()
    {
        $this->twig = $this->createMock(Environment::class);
        $this->router = $this->createMock(RouterInterface::class);
        $this->formFactory = $this->createMock(FormFactoryInterface::class);
        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->request = $this->createMock(Request::class);
    }

    public function testShouldRenderNewPage()
    {
        $form = $this->createMock(FormInterface::class);
        $form->expects($this->once())->method('handleRequest')->with($this->request);
        $form->expects($this->once())->method('isSubmitted')->willReturn(false);
        $form->expects($this->never())->method('isValid');
        $form->expects($this->once())->method('createView')->willReturn(null);

        $this->em->expects($this->never())->method('persist');
        $this->em->expects($this->never())->method('flush');

        $this->router->expects($this->never())->method('generate');

        $this->twig
            ->expects($this->once())
            ->method('render')
            ->willReturnCallback(function (string $template, array $params) {
                $this->assertSame('components/pages/firm/new.html.twig', $template);
                $this->assertCount(2, $params);
                $this->assertArrayHasKey('firm', $params);
                $this->assertArrayHasKey('form', $params);
                $this->assertInstanceOf(Firm::class, $params['firm']);
                $this->assertNull($params['form']);

                return 'OK';
            })
        ;

        $this->formFactory
            ->expects($this->once())
            ->method('create')
            ->with(FirmType::class, $this->isInstanceOf(Firm::class))
            ->willReturn($form)
        ;

        $controller = $this->getController();
        $this->assertInstanceOf(Response::class, $controller->new($this->request));
    }

    public function testShouldNotAddNewFirmBecauseFormIsNotValid()
    {
        $form = $this->createMock(FormInterface::class);
        $form->expects($this->once())->method('handleRequest')->with($this->request);
        $form->expects($this->once())->method('isSubmitted')->willReturn(true);
        $form->expects($this->once())->method('isValid')->willReturn(false);
        $form->expects($this->once())->method('createView')->willReturn(null);

        $this->em->expects($this->never())->method('persist');
        $this->em->expects($this->never())->method('flush');

        $this->router->expects($this->never())->method('generate');

        $this->twig
            ->expects($this->once())
            ->method('render')
            ->willReturnCallback(function (string $template, array $params) {
                $this->assertSame('components/pages/firm/new.html.twig', $template);
                $this->assertCount(2, $params);
                $this->assertArrayHasKey('firm', $params);
                $this->assertArrayHasKey('form', $params);
                $this->assertInstanceOf(Firm::class, $params['firm']);
                $this->assertNull($params['form']);

                return 'OK';
            })
        ;

        $this->formFactory
            ->expects($this->once())
            ->method('create')
            ->with(FirmType::class, $this->isInstanceOf(Firm::class))
            ->willReturn($form)
        ;

        $controller = $this->getController();
        $this->assertInstanceOf(Response::class, $controller->new($this->request));
    }

    public function testShouldAddNewFirm()
    {
        $form = $this->createMock(FormInterface::class);
        $form->expects($this->once())->method('handleRequest')->with($this->request);
        $form->expects($this->once())->method('isSubmitted')->willReturn(true);
        $form->expects($this->once())->method('isValid')->willReturn(true);
        $form->expects($this->never())->method('createView');

        $this->em->expects($this->once())->method('persist')->with($this->isInstanceOf(Firm::class));
        $this->em->expects($this->once())->method('flush');

        $this->router->expects($this->once())->method('generate')->with('firm_index')->willReturn('/firms');

        $this->twig->expects($this->never())->method('render');

        $this->formFactory
            ->expects($this->once())
            ->method('create')
            ->with(FirmType::class, $this->isInstanceOf(Firm::class))
            ->willReturn($form)
        ;

        $controller = $this->getController();
        $this->assertInstanceOf(RedirectResponse::class, $controller->new($this->request));
    }

    public function testShouldRenderEditPage()
    {
        $firm = $this->createMock(Firm::class);

        $form = $this->createMock(FormInterface::class);
        $form->expects($this->once())->method('handleRequest')->with($this->request);
        $form->expects($this->once())->method('isSubmitted')->willReturn(false);
        $form->expects($this->never())->method('isValid');
        $form->expects($this->once())->method('createView')->willReturn(null);

        $this->em->expects($this->never())->method('persist');
        $this->em->expects($this->never())->method('flush');

        $this->router->expects($this->never())->method('generate');

        $this->twig
            ->expects($this->once())
            ->method('render')
            ->with('components/pages/firm/edit.html.twig', ['firm' => $firm, 'form' => null])
            ->willReturn('OK')
        ;

        $this->formFactory
            ->expects($this->once())
            ->method('create')
            ->with(FirmType::class, $firm)
            ->willReturn($form)
        ;

        $controller = $this->getController();
        $this->assertInstanceOf(Response::class, $controller->edit($this->request, $firm));
    }

    public function testShouldNotEditFirmBecauseFormIsNotValid()
    {
        $firm = $this->createMock(Firm::class);

        $form = $this->createMock(FormInterface::class);
        $form->expects($this->once())->method('handleRequest')->with($this->request);
        $form->expects($this->once())->method('isSubmitted')->willReturn(true);
        $form->expects($this->once())->method('isValid')->willReturn(false);
        $form->expects($this->once())->method('createView')->willReturn(null);

        $this->em->expects($this->never())->method('persist');
        $this->em->expects($this->never())->method('flush');

        $this->router->expects($this->never())->method('generate');

        $this->twig
            ->expects($this->once())
            ->method('render')
            ->with('components/pages/firm/edit.html.twig', ['firm' => $firm, 'form' => null])
            ->willReturn('OK')
        ;

        $this->formFactory
            ->expects($this->once())
            ->method('create')
            ->with(FirmType::class, $firm)
            ->willReturn($form)
        ;

        $controller = $this->getController();
        $this->assertInstanceOf(Response::class, $controller->edit($this->request, $firm));
    }

    public function testShouldEditFirm()
    {
        $firm = $this->createMock(Firm::class);

        $form = $this->createMock(FormInterface::class);
        $form->expects($this->once())->method('handleRequest')->with($this->request);
        $form->expects($this->once())->method('isSubmitted')->willReturn(true);
        $form->expects($this->once())->method('isValid')->willReturn(true);
        $form->expects($this->never())->method('createView');

        $this->em->expects($this->once())->method('flush');

        $this->router->expects($this->once())->method('generate')->with('firm_index')->willReturn('/firms');

        $this->twig->expects($this->never())->method('render');

        $this->formFactory
            ->expects($this->once())
            ->method('create')
            ->with(FirmType::class, $firm)
            ->willReturn($form)
        ;

        $controller = $this->getController();
        $this->assertInstanceOf(RedirectResponse::class, $controller->edit($this->request, $firm));
    }

    private function getController(): EditController
    {
        return new EditController($this->twig, $this->router, $this->formFactory, $this->em);
    }
}
