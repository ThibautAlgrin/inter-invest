<?php

declare(strict_types=1);

namespace App\Controller\Firm;

use App\Entity\Firm;
use App\Form\VersionForm;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Loggable\Entity\LogEntry;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class ShowController.
 */
class ShowController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var Environment
     */
    private $twig;

    public function __construct(EntityManagerInterface $em, FormFactoryInterface $formFactory, Environment $twig)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->twig = $twig;
    }

    /**
     * @Route("/{slug}", name="firm_show", methods={"GET"})
     */
    public function __invoke(Firm $firm, Request $request): Response
    {
        $repo = $this->em->getRepository(LogEntry::class);
        $revisions = $repo->getLogEntries($firm);

        $form = $this->getVersionForm($this->getVersions($revisions));
        $form->handleRequest($request);

        $version = $form->getData();
        if (null !== $version) {
            $repo->revert($firm, $version);
        }

        return new Response($this->twig->render('components/pages/firm/show.html.twig', [
            'firm' => $firm,
            'form' => $form->createView(),
        ]));
    }

    private function convertDateToString(\DateTime $date)
    {
        $formatter = \IntlDateFormatter::create(
            'fr_FR',
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::MEDIUM,
            \IntlTimeZone::createTimeZone($date->getTimezone()->getName())
        );

        return $formatter->format($date->getTimestamp());
    }

    private function getVersions(array $revisions): array
    {
        $revisionsSelect = [];
        /** @var LogEntry $revision */
        foreach ($revisions as $revision) {
            $revisionsSelect[$this->convertDateToString($revision->getLoggedAt())] = $revision->getVersion();
        }

        return $revisionsSelect;
    }

    private function getVersionForm(array $revisionsSelect): FormInterface
    {
        return $this->formFactory->create(VersionForm::class, null, ['choices' => $revisionsSelect]);
    }
}
