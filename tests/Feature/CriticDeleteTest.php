<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CriticDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test supprimer un critic */
    public function it_deletes_a_critic()
    {
        $this->seed();

        $response = $this->delete('/api/critics/1');

        $response->assertStatus(200);
    }

    /** @test supprimer critic inexistant */
    public function it_returns_404_if_critic_not_found()
    {
        $this->seed();

        $response = $this->delete('/api/critics/9999');

        $response->assertStatus(404);
    }
}
