<?php

declare(strict_types=1);

namespace App\Controller\Firm;

use App\Entity\Firm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class ShowController.
 */
class ShowController
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/{id}", name="firm_show", methods={"GET"})
     */
    public function show(Firm $firm): Response
    {
        return new Response($this->twig->render('firm/show.html.twig', [
            'firm' => $firm,
        ]));
    }
}
