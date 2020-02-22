<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Domain;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function addCategory(Request $request)
    {

//        $newCategory = new Category;
//        $newCategory->name = $request->name;
//        $newCategory->domain_id = $request->domain_id;
//        $newCategory->img = $request->img;
//        $newCategory->category_slug = $this->slugify($request->name);
//        $newCategory->save();
//        $domain = Domain::with('categories')->find($request->domain_id);
//        $domain->categories()->save($newCategory);
//        return response()->json([
//            'status' => 'success',
//            'domainChanged' => $domain
//        ], 201);

        $directories = Storage::disk('public')->directories();
        $domain = Domain::find($request->domain_id);
        $slug = Str::slug($domain->name);
        $categoryImg = $request->file('categoryImg');
        $categoryImgExtension = $categoryImg->getClientOriginalExtension();
        $newCategory = new Category;

        try {

            if (!in_array($slug, $directories)) {
                Storage::disk('public')->makeDirectory($slug);
            }

            $categoryImgUrl = Storage::disk('public')->putFileAs($slug, $categoryImg, 'categoryImg.' . $categoryImgExtension);

            $newCategory->name = $request->name;
            $newCategory->domain_id = $request->domain_id;
            $newCategory->description = $request->description;
            $newCategory->img = $categoryImgUrl;
            $newCategory->category_slug = Str::slug($request->name);
            $newCategory->save();

        } catch (Exception $exception) {
            report($exception);
        }

        return response()->json([
            'status' => 'success',
            'category' => $newCategory
        ], 201);

    }

    public function deleteCategory($id)
    {

        $category = Category::destroy($id);

        return response()->json([
            'status' => $category ? 'success' : 'failed',
            'id' => $id
        ], 200);
    }

    public static function slugify($text)
    {

        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }
}
