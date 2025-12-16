<?php

namespace App\Controller\BackOffice;

use App\View\BackOffice\IngredientView;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Manager\BackOffice\IngredientManager;
use Symfony\Component\HttpFoundation\Request;

final class IngredientController extends AbstractController
{
    /**
     * @var IngredientManager $ingredientManager
     */
    private IngredientManager $ingredientManager;
    

    /**
     * @param IngredientManager $ingredientManager
     */

    public function __construct(IngredientManager $ingredientManager)
    {
        $this->ingredientManager = $ingredientManager;
    }

    /**
     * Summary of get
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $ingredientList = $this->ingredientManager->list($data);
        return $this->json([
            'code' => 200,
            'data' => IngredientView::renderView($ingredientList)
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
        $ingredient = $this->ingredientManager->create($data);
        return $this->json([
            'code' => 200,
            'data' => IngredientView::renderView($ingredient)
        ]);
    }
    
}
