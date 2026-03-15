<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EquipmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_equipment(): void
    {
        $this->seed();

        $response = $this->getJson('/api/equipment?page=1');
        $response->assertStatus(200);
        $response->assertJsonCount(5, "data");
        $response->assertJsonFragment(['current_page' => 1]);
    }

    public function test_get_equipment_by_id() {
        $this->seed();

        $response = $this->getJson('/api/equipment/2');
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Casque de vélo']);
    }

    public function test_get_equipment_by_id_should_return_404_when_invalid_id() {
        $response = $this->getJson('/api/equipment/9999');
        $response->assertStatus(404);
    }

    public function test_get_equipment_popularity() {
        $this->seed();

        $response = $this->getJson('/api/equipment/1/popularity');
        $response->assertStatus(200);
        $this->assertGreaterThanOrEqual(0, $response->json('popularity'));
    }

    public function test_get_equipment_popularity_should_return_404_when_invalid_id() {
        $response = $this->getJson('/api/equipment/9999/popularity');
        $response->assertStatus(404);
    }
}
