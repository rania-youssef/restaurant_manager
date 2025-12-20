<?php

namespace App\Controller\BackOffice;

use App\View\BackOffice\DishView;
use App\Manager\BackOffice\DishManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class DishController extends AbstractController
{


    /**
     * @var DishManager $dishManager
     */
    private DishManager $dishManager;
    

    /**
     * @param DishManager $dishManager
     */

    public function __construct(DishManager $dishManager)
    {
        $this->dishManager = $dishManager;
    }

    /**
     * Summary of get
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $dish = $this->dishManager->list($data);
        return $this->json([
            'code' => 200,
            'data' => DishView::renderView($dish)
        ]);
    }

     /**
     * Summary of post
     * @param Request $request
     * @return JsonResponse
     */
    
    public function post(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $dish = $this->dishManager->create($data);
        return $this->json([
            'code' => 200,
            'data' => DishView::renderView($dish)
        ]);
    }
}
