<?php

namespace App\View\BackOffice;

use App\Entity\IngredientCategory;

class IngredientCategoryView
{
    /**
     * Summary of renderView
     * @param mixed $items
     * @return array
     */
    public static function renderView($items):array|null  {
        if (empty($items) === false) {
            if ($items instanceof IngredientCategory) {
                $data[] = $items->jsonSerialize();
            } else {
                $data = [];
                foreach ($items as $item) {
                    $data[] = $item->jsonSerialize();
                }
            }
            return $data;
        }
        return null;
    }
}