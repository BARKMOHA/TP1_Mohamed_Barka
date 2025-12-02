<?php

namespace App\Http\Controllers;
use App\Models\Critic;

use Illuminate\Http\Request;

class CriticController extends Controller
{
    /**
     * @OA\Delete(
     *     path="/api/critics/{id}",
     *     summary="Supprimer une critique",
     *     tags={"Critics"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Critique supprimée"),
     *     @OA\Response(response=404, description="Critique introuvable")
     * )
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


