<?php

declare(strict_types=1);

namespace Impexta\Car\Presentation\Controller\Eshop;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class StoreFilterToSessionController extends AbstractController
{
    /**
     * @Route("/car/store-to-session", name="eshop_car_store_to_session")
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $redirectPath = $request->query->get('redirectPath', '/');
        $manufacturer = $request->request->get('filter')['manufacturer'];
        $model = $request->request->get('filter')['model'];
        $yearOfManufacture = $request->request->get('filter')['yearOfManufacture'];
        $engineCapacity = $request->request->get('filter')['engineCapacity'];

        // store to session if properties are set
        if (isset($manufacturer)) {
            $request->getSession()->set('manufacturer', $manufacturer);
        }

        if (isset($model)) {
            $request->getSession()->set('model', $model);
        }

        if (isset($yearOfManufacture)) {
            $request->getSession()->set('yearOfManufacture', $yearOfManufacture);
        }

        if (isset($engineCapacity)) {
            $request->getSession()->set('engineCapacity', $engineCapacity);
        }

        // redirect
        return $this->redirect($redirectPath);
    }
}
