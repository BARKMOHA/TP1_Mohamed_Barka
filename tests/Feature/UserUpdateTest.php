<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test mise a jour de user */
    public function it_updates_a_user()
    {
        $this->seed();

        $response = $this->putJson('/api/users/1', [
            'name' => 'Updated',
            'email' => 'updated@test.com',
            'password' => 'secret123',
            'language_id' => 1
        ]);

        $response->assertStatus(200);
    }

    /** @test update user inexistant */
    public function returns_404_if_user_not_found()
    {
        $this->seed();

        $response = $this->put('/api/users/9999', [
            'name' => 'Updated',
            'email' => 'updated@test.com',
            'password' => 'secret123',
            'language_id' => 1
        ]);

        $response->assertStatus(404);
    }
}
