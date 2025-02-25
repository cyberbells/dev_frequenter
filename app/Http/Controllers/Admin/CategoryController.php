<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    // Get Parent Categories
    public function getCategories(): JsonResponse
    {
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->get();
    
        return response()->json($categories);
    }

    // Get Parent Categories
    public function getParentCategories(): JsonResponse
    {
        $categories = Category::whereNull('parent_id')->get();
        return response()->json($categories);
    }

    // Get Child Categories by Parent ID
    public function getChildCategories($parentId): JsonResponse
    {
        $categories = Category::where('parent_id', $parentId)->get();
        return response()->json($categories);
    }
}
