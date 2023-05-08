<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\Eshop;

use Impexta\Car\Infrastructure\Model\FilterModelFactory;
use Impexta\Product\Presentation\Form\Type\FilterType;
use Impexta\Product\Presentation\Form\Type\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RenderSearchFormController extends AbstractController
{
    private FilterModelFactory $filterModelFactory;

    public function __construct(
        FilterModelFactory $filterModelFactory
    ) {
        $this->filterModelFactory = $filterModelFactory;
    }

    public function __invoke(Request $request, string $redirectPath, string $searchQuery = ''): Response
    {
        $searchForm = $this->createForm(SearchType::class, ['query' => $searchQuery], [
            'action' => $this->generateUrl('eshop_search'),
        ]);

        $filterModel = $this->filterModelFactory->createFromSession($request->getSession());

        $filterForm = $this->createForm(FilterType::class, $filterModel, [
            'action' => $this->generateUrl('eshop_car_store_to_session', [
                'redirectPath' => $redirectPath,
            ]),
            'choices_from_session' => $this->filterModelFactory->prepareChoicesForForm($filterModel),
        ]);

        return $this->render(
            'Eshop/components/_filter.html.twig',
            [
                'search_form' => $searchForm->createView(),
                'filter_form' => $filterForm->createView(),
            ]
        );
    }
}
