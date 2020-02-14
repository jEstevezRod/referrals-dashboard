<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Domain;
use App\Models\User;
use App\Notifications\DomainCreated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class JsonController extends Controller
{

    public function download($id)
    {
        $domain = Domain::with('categories')->find($id);
        $categories = $domain['categories'];
        $output = [];
        foreach ($categories as $index => $category) {
            $localCategory = Category::with('products')->find($category->id);
            $products = $localCategory->products;
            $output[$index]['id'] = $localCategory->id;
            $output[$index]['name'] = $localCategory->name;
            $output[$index]['img'] = $localCategory->img;
            $output[$index]['category_slug'] = $localCategory->category_slug;
            $output[$index]['domain_id'] = $localCategory->domain_id;
            foreach ($products as $i => $product) {
                $output[$index]['products'][$i]['id'] = $product->id;
                $output[$index]['products'][$i]['name'] = $product->name;
                $output[$index]['products'][$i]['price'] = $product->price;
                $output[$index]['products'][$i]['img'] = $product->img;
                $output[$index]['products'][$i]['slug'] = $product->slug;
                $output[$index]['products'][$i]['category_name'] = $product->category_name;
                $output[$index]['products'][$i]['amazon_url'] = $product->amazon_url;
                $output[$index]['products'][$i]['cat_id'] = $product->cat_id;
                $output[$index]['products'][$i]['description'] = $product->description;
            }
        }
        $data = json_encode($output);
//        $filename = 'products.json';
//        Storage::disk('public')->put("/" . $filename, $data);
//        $file = storage_path() . "/app/public/" . $filename;
//        $headers = array(
//            'Content-Type:' => 'application/json'
//        );

        Log::channel('slack')->notice('New content has been generated for domain: ' . $domain['name']);

        return response()->json($data);
    }


    function getToken(Request $request) {
        return response()->json($request);
    }
}
