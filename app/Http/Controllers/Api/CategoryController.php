<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Domain;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function addCategory(Request $request){

        $newCategory = new Category;
        $newCategory->name = $request->name;
        $newCategory->domain_id = $request->domain_id;
        $newCategory->img = $request->img;
        $newCategory->category_slug = $this->slugify($request->name);
        $newCategory->save();

        $domain = Domain::with('categories')->find($request->domain_id);

//        $domain->categories()->save($newCategory);


        return response()->json([
            'status' => 'success',
            'domainChanged' => $domain
        ], 201);
    }

    public function deleteCategory($id) {

        $category = Category::destroy($id);

        return response()->json([
            'status' => $category ? 'success' : 'failed',
            'id' => $id
        ], 200);
    }

    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
