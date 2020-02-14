<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator;
use App\Models\Domain;

class SitemapController extends Controller
{
    public function generateSitemap(Request $request)
    {

        $domain = Domain::find($request->id);
        return SitemapGenerator::create($domain->url)
            ->getSitemap()
            ->toResponse($request);
//            ->render();
//            ->writeToFile(public_path('sitemap.xml'));
    }
}
