<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_user() {
        $this->seed();

        $json = [
            "first_name" => "Test",
            "last_name" => "Test",
            "email" => "test123@gmail.com",
            "phone" => "1234567890"
        ];

        $response = $this->postJson('/api/users', $json);

        $response->assertStatus(201);
        $response->assertJsonFragment(['first_name' => 'Test']);
        $response->assertJsonFragment(['last_name' => 'Test']);
        $response->assertJsonFragment(['email' => 'test123@gmail.com']);
        $response->assertJsonFragment(['phone' => '1234567890']);
        $this->assertDatabaseHas('users', $json);
    }

    public function test_post_user_should_return_422_when_missing_field() {
        $json = [
            "first_name" => "Test",
            "last_name" => "Test",
            "phone" => "1234567890"
        ];

        $response = $this->postJson('/api/users', $json);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_put_user() {
        $this->seed();

        $json = [
            "first_name" => "Updated",
            "last_name" => "User",
            "email" => "updated@gmail.com",
            "phone" => "0987654321"
        ];

        $response = $this->putJson('/api/users/1', $json);

        $response->assertStatus(200);
        $response->assertJsonFragment(['first_name' => 'Updated']);
        $response->assertJsonFragment(['last_name' => 'User']);
        $response->assertJsonFragment(['email' => 'updated@gmail.com']);
        $response->assertJsonFragment(['phone' => '0987654321']);
        $this->assertDatabaseHas('users', $json);
    }

    public function test_put_user_should_return_404_when_invalid_id() {
        $json = [
            "first_name" => "Updated",
            "last_name" => "User",
            "email" => "updated@gmail.com",
            "phone" => "0987654321"
        ];

        $response = $this->putJson('/api/users/9999', $json);

        $response->assertStatus(404);
    }

    public function test_put_user_should_return_422_when_missing_field() {
        $json = [
            "first_name" => "Updated",
            "last_name" => "User",
            "phone" => "0987654321"
        ];

        $response = $this->putJson('/api/users/1', $json);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }
}
