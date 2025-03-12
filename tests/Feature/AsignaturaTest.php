<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Asignatura;

class AsignaturaTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    use RefreshDatabase;

    /** @test */
    public function it_can_list_asignaturas()
    {
        Asignatura::factory()->count(3)->create();

        $response = $this->get('/api/asignaturas');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }
    /** @test */
    public function it_can_create_an_asignatura()
    {
        $data = [
            'nombre' => 'Matemáticas',
            'curso' => '1o'
        ];

        $response = $this->post('/api/asignaturas', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('asignaturas', $data);
    }
    /** @test */
    public function it_can_update_an_asignatura()
    {
        $asignatura = Asignatura::factory()->create();

        $data = [
            'nombre' => 'Física',
            'curso' => '2o'
        ];

        $response = $this->put("/api/asignaturas/{$asignatura->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('asignaturas', $data);
    }
     /** @test */
     public function it_can_delete_an_asignatura()
     {
         $asignatura = Asignatura::factory()->create();
 
         $response = $this->delete("/api/asignaturas/{$asignatura->id}");
 
         $response->assertStatus(204);
         $this->assertDatabaseMissing('asignaturas', [
             'id' => $asignatura->id
         ]);
     }
}
