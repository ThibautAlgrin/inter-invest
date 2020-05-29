<?php

declare(strict_types=1);

namespace App\Tests\Controller\Firm;

use App\Controller\Firm\IndexController;
use App\Repository\FirmRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

/**
 * Class IndexControllerTest.
 *
 * @codingStandardsIgnoreFile
 *
 * @SuppressWarnings(PHPMD)
 */
class IndexControllerTest extends TestCase
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

    /**
     * @var Request
     */
    private $request;

    protected function setUp()
    {
        $this->repository = $this->createMock(FirmRepository::class);
        $this->twig = $this->createMock(Environment::class);
        $this->paginator = $this->createMock(PaginatorInterface::class);
        $this->request = $this->createMock(Request::class);
    }

    /**
     * @dataProvider dataProviderTestShouldRenderListPage
     */
    public function testShouldRenderListPage(int $page)
    {
        $this->repository->expects($this->once())->method('getQuery')->willReturn(null);
        $query = $this->createMock(ParameterBag::class);
        $query->expects($this->once())->method('getInt')->with('page', 1)->willReturn($page);
        $this->request->query = $query;

        $paginate = $this->createMock(PaginationInterface::class);
        $this->paginator->expects($this->once())->method('paginate')->with(null, $page, 5)->willReturn($paginate);

        $this->twig
            ->expects($this->once())
            ->method('render')
            ->with('components/pages/firm/index.html.twig', [
                'firms' => $paginate,
            ])
        ;

        $controller = $this->getController();
        $controller->__invoke($this->request);
    }

    public function dataProviderTestShouldRenderListPage(): array
    {
        return [
            [1],
            [2],
        ];
    }

    private function getController(): IndexController
    {
        return new IndexController($this->repository, $this->paginator, $this->twig);
    }
}
