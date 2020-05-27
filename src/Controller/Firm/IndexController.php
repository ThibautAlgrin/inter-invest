<?php

declare(strict_types=1);

namespace App\Controller\Firm;

use App\Repository\FirmRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class IndexController.
 */
class IndexController
{
    /**
     * @var FirmRepository
     */
    private $repository;

    /**
     * @var Environment
     */
    private $twig;

    public function __construct(FirmRepository $repository, Environment $twig)
    {
        $this->repository = $repository;
        $this->twig = $twig;
    }

    /**
     * @Route("/", name="firm_index", methods={"GET"})
     */
    public function __invoke(): Response
    {
        return new Response($this->twig->render('firm/index.html.twig', [
            'firms' => $this->repository->findAll(),
        ]));
    }
}
