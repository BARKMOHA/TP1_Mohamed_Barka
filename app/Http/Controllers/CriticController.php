<?php

namespace App\Http\Controllers;
use App\Models\Critic;

use Illuminate\Http\Request;

class CriticController extends Controller
{
    /**
     *  Supprimer une critique
     */
    public function destroy($id)
    {
        $critic = Critic::find($id);

        if (!$critic) {
            return response()->json([
                'message' => 'Critic not found'
            ])->setStatusCode(404);
        }

        $critic->delete();

        return response()->json([
            'message' => 'Critic deleted successfully'
        ])->setStatusCode(200);
    }

    
}


