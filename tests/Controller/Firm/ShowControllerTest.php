<?php

declare(strict_types=1);

namespace App\Tests\Controller\Firm;

use App\Controller\Firm\ShowController;
use App\Entity\Firm;
use App\Form\VersionForm;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Loggable\Entity\LogEntry;
use Gedmo\Loggable\Entity\Repository\LogEntryRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * Class ShowControllerTest.
 *
 * @codingStandardsIgnoreFile
 *
 * @SuppressWarnings(PHPMD)
 */
class ShowControllerTest extends TestCase
{
    /**
     * @var EntityManagerInterface|MockObject
     */
    private $em;

    /**
     * @var FormFactoryInterface|MockObject
     */
    private $formFactory;

    /**
     * @var Environment|MockObject
     */
    private $twig;

    /**
     * @var Firm
     */
    private $firm;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var LogEntryRepository
     */
    private $repo;

    protected function setUp()
    {
        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->formFactory = $this->createMock(FormFactoryInterface::class);
        $this->twig = $this->createMock(Environment::class);
        $this->firm = $this->createMock(Firm::class);
        $this->request = $this->createMock(Request::class);
        $this->repo = $this->createMock(LogEntryRepository::class);
    }

    public function testShouldRenderShowActionWithOutRevision()
    {
        $this->em->expects($this->once())->method('getRepository')->with(LogEntry::class)->willReturn($this->repo);
        $this->repo
            ->expects($this->once())
            ->method('getLogEntries')
            ->with($this->firm)
            ->willReturn($this->getRevisions())
        ;
        $this->repo->expects($this->never())->method('revert');

        $form = $this->createMock(FormInterface::class);
        $form->expects($this->once())->method('handleRequest')->with($this->request);
        $form->expects($this->once())->method('getData')->willReturn(null);
        $form->expects($this->once())->method('createView');

        $this->formFactory
            ->expects($this->once())
            ->method('create')
            ->with(
                VersionForm::class,
                null,
                [
                    'choices' => [
                        '18 mars 2020 à 00:00:00' => 1,
                        '1 mai 2020 à 00:00:00' => 2,
                    ],
                ]
            )
            ->willReturn($form)
        ;

        $this->twig
            ->expects($this->once())
            ->method('render')
            ->with(
                'components/pages/firm/show.html.twig',
                [
                    'firm' => $this->firm,
                    'form' => null,
                ]
            )
            ->willReturn('OK')
        ;

        $controller = $this->getController();
        $controller->__invoke($this->firm, $this->request);
    }

    public function testShouldRenderShowActionWithRevision()
    {
        $this->em->expects($this->once())->method('getRepository')->with(LogEntry::class)->willReturn($this->repo);
        $this->repo
            ->expects($this->once())
            ->method('getLogEntries')
            ->with($this->firm)
            ->willReturn($this->getRevisions())
        ;
        $this->repo->expects($this->once())->method('revert')->with($this->firm, 1);

        $form = $this->createMock(FormInterface::class);
        $form->expects($this->once())->method('handleRequest')->with($this->request);
        $form->expects($this->once())->method('getData')->willReturn(1);
        $form->expects($this->once())->method('createView');

        $this->formFactory
            ->expects($this->once())
            ->method('create')
            ->with(
                VersionForm::class,
                null,
                [
                    'choices' => [
                        '18 mars 2020 à 00:00:00' => 1,
                        '1 mai 2020 à 00:00:00' => 2,
                    ],
                ]
            )
            ->willReturn($form)
        ;

        $this->twig
            ->expects($this->once())
            ->method('render')
            ->with(
                'components/pages/firm/show.html.twig',
                [
                    'firm' => $this->firm,
                    'form' => null,
                ]
            )
            ->willReturn('OK')
        ;

        $controller = $this->getController();
        $this->assertInstanceOf(Response::class, $controller->__invoke($this->firm, $this->request));
    }

    private function getRevisions(): array
    {
        $revisions = [];
        $revision = $this->createMock(LogEntry::class);
        $revision->expects($this->once())->method('getLoggedAt')->willReturn(new \DateTime('2020-03-18'));
        $revision->expects($this->once())->method('getVersion')->willReturn(1);
        $revisions[] = $revision;
        $revision = $this->createMock(LogEntry::class);
        $revision->expects($this->once())->method('getLoggedAt')->willReturn(new \DateTime('2020-05-01'));
        $revision->expects($this->once())->method('getVersion')->willReturn(2);
        $revisions[] = $revision;

        return $revisions;
    }

    private function getController(): ShowController
    {
        return new ShowController($this->em, $this->formFactory, $this->twig);
    }
}
