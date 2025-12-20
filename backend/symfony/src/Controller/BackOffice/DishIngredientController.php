<?php

namespace App\Controller\BackOffice;

use App\View\BackOffice\DishIngredientView;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Manager\BackOffice\DishIngredientManager;
use Symfony\Component\HttpFoundation\Request;

final class DishIngredientController extends AbstractController
{
    /**
     * @var DishIngredientManager $dishIngredientManager
     */
    private DishIngredientManager $dishIngredientManager;
    

    /**
     * @param DishIngredientManager $dishIngredientManager
     */

    public function __construct(DishIngredientManager $dishIngredientManager)
    {
        $this->dishIngredientManager = $dishIngredientManager;
    }

    /**
     * Summary of get
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $dishIngredientList = $this->dishIngredientManager->list($data);
        return $this->json([
            'code' => 200,
            'data' => DishIngredientView::renderView($dishIngredientList)
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
        $dishIngredient = $this->dishIngredientManager->create($data);
        return $this->json([
            'code' => 200,
            'data' => DishIngredientView::renderView($dishIngredient)
        ]);
    }
    
}
