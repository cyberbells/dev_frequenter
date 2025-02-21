<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Get all Categories routes in JSON format.
     *
     * @return JsonResponse
    */

    public function getCategories()
    {
        $categories = Category::select('id', 'name')->orderBy('id', 'asc')->get();

        return response()->json([
            'status' => true,
            'message' => 'Categories retrieved successfully',
            'data' => $categories
        ], 200);
    }
}
