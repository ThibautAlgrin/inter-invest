<?php

declare(strict_types=1);

namespace App\Controller\Firm;

use App\Entity\Firm;
use App\Form\FirmType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

/**
 * Class EditController.
 */
class EditController
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        Environment $twig,
        RouterInterface $router,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $em
    ) {
        $this->twig = $twig;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->em = $em;
    }

    /**
     * @Route("/new", name="firm_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $firm = new Firm();
        $form = $this->formFactory->create(FirmType::class, $firm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($firm);
            $this->em->flush();

            return new RedirectResponse($this->router->generate('firm_index'));
        }

        return new Response($this->twig->render('firm/new.html.twig', [
            'firm' => $firm,
            'form' => $form->createView(),
        ]));
    }

    /**
     * @Route("/{id}/edit", name="firm_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Firm $firm): Response
    {
        $form = $this->formFactory->create(FirmType::class, $firm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return new RedirectResponse($this->router->generate('firm_index'));
        }

        return new Response($this->twig->render('firm/edit.html.twig', [
            'firm' => $firm,
            'form' => $form->createView(),
        ]));
    }
}
