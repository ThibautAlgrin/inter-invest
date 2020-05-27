<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class DefaultController.
 */
class DefaultController
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * DefaultController constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @Route("/", name="home")
     */
    public function __invoke()
    {
        return new RedirectResponse($this->router->generate('firm_index'));
    }
}
