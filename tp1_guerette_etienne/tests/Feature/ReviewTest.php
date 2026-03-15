<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_review() {
        $this->seed();

        $response = $this->deleteJson('/api/reviews/2');
        $response->assertStatus(204);
    }

    public function test_delete_review_should_return_404_when_invalid_id() {
        $response = $this->deleteJson('/api/reviews/9999');
        $response->assertStatus(404);
    }
}
