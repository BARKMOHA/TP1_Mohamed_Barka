<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FilmActorsTest extends TestCase
{
    use RefreshDatabase;
    /** @test returns film actors*/
    public function returns_actors_film()
    {
        $this->seed();

        $response = $this->get('/api/films/1/actors');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                    'birthdate'
                ]
            ]
        ]);
    }

    /** @test reterns 404 film not found*/
    public function returns_404_film_not_found()
    {
        $this->seed();

        $response = $this->get('/api/films/99999/actors');

        $response->assertStatus(404);
    }
}
