<?php

namespace App\Http\Controllers;
use App\Models\Film;
use Illuminate\Http\Request;
use App\Http\Resources\FilmResource;
use App\Http\Resources\ActorResource;
use App\Http\Resources\CriticResource;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        $films = Film::paginate(20);
    
        return FilmResource::collection($films)
            ->response()
            ->setStatusCode(200);
    }
    
    public function show($id)
    {
       //
    }
    
    public function actors($id)
    {
        $film = Film::with('actors')->find($id);
    
        if (!$film) {
            return response()->json(['message' => 'Film not found'])
                ->setStatusCode(404);
        }
    
        return ActorResource::collection($film->actors)
            ->response()
            ->setStatusCode(200);
    }
    
    public function critics($id)
    {
        $film = Film::with('critics')->find($id);
    
        if (!$film) {
            return response()->json(['message' => 'Film not found'])
                ->setStatusCode(404);
        }
    
        return CriticResource::collection($film->critics)
            ->response()
            ->setStatusCode(200);
    }
    
    /**
     *  Moyenne des scores d’un film
     */
    public function averageScore($id)
    {
        $film = Film::with('critics')->find($id);

        if (!$film) {
            return response()->json(['message' => 'Film not found'])
                ->setStatusCode(404);
        }

        if ($film->critics->isEmpty()) {
            return response()->json(['average_score' => null])
                ->setStatusCode(200);
        }

        $average = round($film->critics->avg('rating'), 2);

        return response()->json(['average_score' => $average])
            ->setStatusCode(200);
    }

    /**
     *  Recherche de films
     * https://laravel.com/docs/12.x/scout#searching
     */
    public function search(Request $request)
    {
        $query = Film::query();

        // par titre
        if ($request->filled('keyword')) {
            $query->where('title', 'LIKE', '%' . $request->keyword . '%');
        }

        //  rating 
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        //  minLength
        if ($request->filled('minLength')) {
            $query->where('length', '>=', $request->minLength);
        }

        //  maxLength 
        if ($request->filled('maxLength')) {
            $query->where('length', '<=', $request->maxLength);
        }
        //paginer le resultat de search
        $films = $query->paginate(20);

        return FilmResource::collection($films)
            ->response()
            ->setStatusCode(200);
    }

        
}
