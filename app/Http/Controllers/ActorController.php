<?php

namespace App\Http\Controllers;
use App\Models\Actor;

use Illuminate\Http\Request;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actors = Actor::all();

        return ActorResource::collection($actors)
            ->response()
            ->setStatusCode(200);
    }

    public function show($id)
    {
        $actor = Actor::find($id);

        if (!$actor) {
            return response()->json(['message' => 'Actor not found'])
                ->setStatusCode(404);
        }

        return (new ActorResource($actor))
            ->response()
            ->setStatusCode(200);
    }

    public function films($id)
    {
        $actor = Actor::with('films')->find($id);

        if (!$actor) {
            return response()->json(['message' => 'Actor not found'])
                ->setStatusCode(404);
        }

        return FilmResource::collection($actor->films)
            ->response()
            ->setStatusCode(200);
    }

}
