<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Domain;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DomainController extends Controller
{
    function listDomains()
    {
        $domains = Domain::with('categories')->get();

        return response()->json([
            'status' => 'success',
            'data' => $domains
        ], 200);
    }

    function getDomain(Request $request, $id)
    {
        $id = $request->id || $id;

        $domain = Domain::find($id);

        return response()->json([
            'status' => 'success',
            'data' => $domain
        ], 200);
    }

    function createDomain(Request $request)
    {
        $newDomain = new Domain;
        $newDomain->name = $request->name;
        $newDomain->url = $request->url;
        $newDomain->save();

        return response()->json([
            'status' => 'success',
            'domain' => $newDomain
        ], 201);

    }

    function deleteDomain($id)
    {

        $domain = Domain::destroy($id);

        return response()->json([
            'status' => $domain ? 'success' : 'failed',
            'id' => $id
        ], 200);
    }

    function updateDomain(Request $request)
    {
        $domain = Domain::find($request->id);
        $slug = Str::slug($domain->name);
        $directories = Storage::disk('public')->directories();
        $hero = $request->file('homeHeroImage');
        $heroExt = $hero->getClientOriginalExtension();
        $favicon = $request->file('websiteIcon');

        try {
            if (!in_array($slug, $directories)) {
                Storage::disk('public')->makeDirectory($slug);
            }
            $heroUrl = Storage::disk('public')->putFileAs($slug, $hero, 'homeHeroImage.' . $heroExt);
            $faviconUrl = Storage::disk('public')->putFileAs($slug, $hero, 'favicon.ico');

        } catch (\Exception $exception) {
            throw $exception;
        }

        $domain->homeHeaderTitle = $request->homeHeaderTitle;
        $domain->homeExplanation = $request->homeExplanation;
        $domain->categoriesExplanation = $request->categoriesExplanation;
        $domain->homeHeroImage = $heroUrl;
        $domain->websiteIcon = $faviconUrl;
        $updated = $domain->save();

        return response()->json($updated);
    }
}
