<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FilmTest extends TestCase
{
    use RefreshDatabase;

    public function returns_all_films()
    {
        $this->seed();

        $response = $this->get('/api/films');

        $response->assertStatus(200);
        //https://laravel.com/docs/master/http-tests#assert-json-structure
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'release_year',
                    'language_id',
                    'length',
                    'rating',
                    'special_features',
                    'image'
                ]
            ],
            'links',
            'meta'
        ]);
    }
}
