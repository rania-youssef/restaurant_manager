<?php

namespace App\Controller\BackOffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Manager\BackOffice\IngredientCategoryManager;
use App\View\BackOffice\IngredientCategoryView;


final class IngredientCategoryController extends AbstractController
{
    /**
     * @var IngredientCategoryManager $ingredientCategoryManager
     */
    private IngredientCategoryManager $ingredientCategoryManager;
    

    /**
     * @param IngredientCategoryManager $ingredientCategoryManager
     */

    public function __construct(IngredientCategoryManager $ingredientCategoryManager)
    {
        $this->ingredientCategoryManager = $ingredientCategoryManager;
    }

    /**
     * Summary of get
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $ingredientCategoryList = $this->ingredientCategoryManager->list($data);
        return $this->json([
            'code' => 200,
            'data' => IngredientCategoryView::renderView($ingredientCategoryList)
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
        $ingredientCategoryList = $this->ingredientCategoryManager->create($data);
        return $this->json([
            'code' => 200,
            'data' => IngredientCategoryView::renderView($ingredientCategoryList)
        ]);
    }
}
