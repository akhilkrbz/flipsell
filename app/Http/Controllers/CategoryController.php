<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
{
    // Fetch all parent categories where sub_of is 0
    $categories = Category::where('sub_of', 0)->get();

    // Transform data into the required format
    $formattedCategories = $categories->map(function ($category) {
        return [
            "category_id" => $category->id,
            "category_name" => $category->category_name,
            "subcategories" => Category::where('sub_of', $category->id)->get()->map(function ($sub) {
                return [
                    "subcategory_id" => $sub->id,
                    "subcategory_name" => $sub->category_name
                ];
            })->toArray()
        ];
    });

    // Return response
    return response()->json([
        "success" => true,
        "message" => "Categories fetched successfully",
        "data" => $formattedCategories
    ], 200);
}

}
