<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserStoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test creation */
    public function create_a_user()
    {
        $this->seed();

        $response = $this->post('/api/users', [
            'name' => 'John Doe',
            'email' => 'john@test.com',
            'password' => 'secret123',
            'language_id' => 1
        ]);

        $response->assertStatus(201);
    }

    /** @test email utilise*/
    public function returns_422_if_email_taken()
    {
        $this->seed();

        $this->post('/api/users', [
            'name' => 'User X',
            'email' => 'john@test.com',
            'password' => 'secret123',
            'language_id' => 1
        ]);
        //https://laravel.com/docs/12.x/http-tests#testing-json-apis
        $response = $this->postJson('/api/users', [
            'name' => 'Another User',
            'email' => 'john@test.com',
            'password' => 'secret123',
            'language_id' => 1
        ]);

        $response->assertStatus(422);
    }

    /** @test language no valide */
    public function returns_422_if_language_invalid()
    {
        $this->seed();

        $response = $this->postJson('/api/users', [
            'name' => 'Test',
            'email' => 'test@test.com',
            'password' => 'abc12345',
            'language_id' => 9999
        ]);

        $response->assertStatus(422);
    }
}
