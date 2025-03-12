<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Nota;

class NotaTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_nota()
    {
        $estudiante = \App\Models\Estudiante::factory()->create();
        $asignatura = \App\Models\Asignatura::factory()->create();

        $data = [
            'estudiante_id' => $estudiante->id,
            'asignatura_id' => $asignatura->id,
            'nota' => 8.5,
        ];

        $response = $this->post('/api/notas', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('notas', $data);
    }
    /** @test */
    public function it_can_update_a_nota()
    {
        $estudiante = \App\Models\Estudiante::factory()->create();
        $asignatura = \App\Models\Asignatura::factory()->create();
        $nota = \App\Models\Nota::factory()->create([
            'estudiante_id' => $estudiante->id,
            'asignatura_id' => $asignatura->id,
            'nota' => 7.0,
        ]);

        $data = [
            'nota' => 9.5,
        ];

        $response = $this->put("/api/notas/{$nota->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('notas', array_merge(['id' => $nota->id], $data));
    }
    /** @test */
    public function it_can_delete_a_nota()
    {
        $estudiante = \App\Models\Estudiante::factory()->create();
        $asignatura = \App\Models\Asignatura::factory()->create();
        $nota = \App\Models\Nota::factory()->create([
            'estudiante_id' => $estudiante->id,
            'asignatura_id' => $asignatura->id,
            'nota' => 8.0,
        ]);

        $response = $this->delete("/api/notas/{$nota->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('notas', ['id' => $nota->id]);
    }
    /** @test */
    public function it_can_get_notas_by_estudiante()
    {
        $estudiante = \App\Models\Estudiante::factory()->create();
        $asignatura = \App\Models\Asignatura::factory()->create();
        $nota = \App\Models\Nota::factory()->create([
            'estudiante_id' => $estudiante->id,
            'asignatura_id' => $asignatura->id,
            'nota' => 8.5,
        ]);

        $response = $this->get("/api/estudiantes/{$estudiante->id}/notas");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'asignatura' => $asignatura->nombre,
            'nota' => '8.50',
        ]);
    }
    /** @test */
    public function it_can_get_media_of_notas_by_estudiante()
    {
        $estudiante = \App\Models\Estudiante::factory()->create();
        $asignatura1 = \App\Models\Asignatura::factory()->create();
        $asignatura2 = \App\Models\Asignatura::factory()->create();

        \App\Models\Nota::factory()->create([
            'estudiante_id' => $estudiante->id,
            'asignatura_id' => $asignatura1->id,
            'nota' => 8.0,
        ]);
        \App\Models\Nota::factory()->create([
            'estudiante_id' => $estudiante->id,
            'asignatura_id' => $asignatura2->id,
            'nota' => 9.0,
        ]);

        $response = $this->get("/api/estudiantes/{$estudiante->id}/media");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'media' => 8.5,  
        ]);
    }
}
