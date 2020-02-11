<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Domain;
use App\Models\Category;

class ProductController extends Controller
{
    public function createProduct(Request $request)
    {

        $product = new Product;

        $product->name = $request->name;
        $product->price = $request->price;
        $product->img = $request->img;
        $product->amazon_url = $request->amazon_url;
        $product->description = $request->description;
        $product->category_name = $request->category_name;
        $product->cat_id = $request->cat_id;
        $product->slug = $request->slug;
        $product->save();


        return response()->json([
            'status' => 'success',
            'product' => $product
        ], 201);
    }

    public function loadTree($id)
    {
        $domain = Domain::with('categories')->find($id);

        $categories = $domain['categories'];

        $output = [];
        $count = 0;
        foreach ($categories as $index => $category) {
            $count++;
            $localCategory = Category::with('products')->find($category->id);
            $products = $localCategory->products;
            $numberProducts = count($products);
            $output[$index]['name'] = $localCategory->name . ' ' . '( ' . $numberProducts . ' )';
            $output[$index]['id'] = $count;
            foreach ($products as $i => $product) {
                $count++;
                $output[$index]['children'][$i]['name'] = $product->name;
                $output[$index]['children'][$i]['id'] = $count;
            }
        }

        return response()->json($output);
    }
}
