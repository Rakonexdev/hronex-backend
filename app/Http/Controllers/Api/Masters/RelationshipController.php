<?php

namespace App\Http\Controllers\Api\Masters;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RelationshipController extends Controller
{
    public function relationships()
    {
        try {
            $activeRelationships = DB::table('relationship')
                ->where('active', true)
                ->select('id', 'name', 'active')
                ->get();

            return response()->json($activeRelationships);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }
}