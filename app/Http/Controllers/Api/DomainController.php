<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Domain;

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

    function deleteDomain( $id) {

        $domain = Domain::destroy($id);

        return response()->json([
            'status' => $domain ? 'success' : 'failed',
            'id' => $id
        ], 200);
    }
}
