<?php


namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @class         CategoryController
 * @brief        Category Controller
 *
 * @author
 * @copyright (C) 2021 Smooth
 *
 * @version       1.0
 * @date          2021-01-27
 */
class CategoryController extends Controller
{
    /**
     * @name CategoryLists
     * @brief         Category Lists
     *
     * @author        Liu
     * @date          2021-01-27
     */
    public function CategoryList(Category $category)
    {
        return response()->json(
            [
                'code' => '1',
                'msg' => 'ok',
                'data' => $category
            ],
            200,
            );
    }
}
