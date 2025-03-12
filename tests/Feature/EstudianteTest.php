<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Estudiante;

class EstudianteTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    use RefreshDatabase; // Limpia la BBDD antes de cada test

    /** @test */
    public function it_can_list_estudiantes()
    {
        Estudiante::factory()->count(3)->create(); 

        $response = $this->getJson('/api/estudiantes');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /** @test */
    public function it_can_create_a_estudiante()
    {
        $data = [
            'nombre' => 'Juan',
            'apellidos' => 'Pérez',
            'edad' => 20,
        ];

        $response = $this->postJson('/api/estudiantes', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['nombre' => 'Juan']);
        
        $this->assertDatabaseHas('estudiantes', $data);
    }

    /** @test */
    public function it_can_update_a_estudiante()
    {
        $student = Estudiante::factory()->create();

        $data = [
            'nombre' => 'Pedro',
            'apellidos' => 'García',
            'edad' => 25,
        ];

        $response = $this->putJson("/api/estudiantes/{$student->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['nombre' => 'Pedro']);
        
        $this->assertDatabaseHas('estudiantes', $data);
    }

    /** @test */
    public function it_can_delete_a_estudiante()
    {
        $student = Estudiante::factory()->create();

        $response = $this->deleteJson("/api/estudiantes/{$student->id}");

        $response->assertStatus(204); 
        $this->assertDatabaseMissing('estudiantes', ['id' => $student->id]);
    }

}
