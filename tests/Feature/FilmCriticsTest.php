<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FilmCriticsTest extends TestCase
{
    use RefreshDatabase;

    /** @test return critics for a film*/
    public function returns_critics_for_a_film()
    {
        $this->seed();

        $response = $this->get('/api/films/1/critics');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'film_id',
                    'user_id',
                    'rating',
                    'comment',
                    'created_at'
                ]
            ]
        ]);
    }

    /** @test 404 film not found*/
    public function returns_404_invalid_film()
    {
        $this->seed();

        $response = $this->get('/api/films/99999/critics');

        $response->assertStatus(404);
    }
}
