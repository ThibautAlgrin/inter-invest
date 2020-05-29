<?php

declare(strict_types=1);

namespace App\Controller\Firm;

use App\Repository\FirmRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(FirmRepository $repository, PaginatorInterface $paginator, Environment $twig)
    {
        $this->repository = $repository;
        $this->paginator = $paginator;
        $this->twig = $twig;
    }

    /**
     * @Route("/", name="firm_index", methods={"GET"})
     */
    public function __invoke(Request $request): Response
    {
        $query = $this->repository->getQuery();

        return new Response($this->twig->render('components/pages/firm/index.html.twig', [
            'firms' => $this->paginator->paginate($query, $request->query->getInt('page', 1), 5),
        ]));
    }
}
