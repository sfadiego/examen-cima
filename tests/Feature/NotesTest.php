<?php

namespace Tests\Feature;

use App\Enums\NoteStatesEnum;
use App\Models\Notes;
use Tests\TestCase;

class NotesTest extends TestCase
{
    public function test_get_active_notes()
    {
        Notes::factory()->count(10)->create();
        $response = $this->get('/api/v1/notes');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'content',
                    'state',
                    'setted'
                ]
            ]
        ]);

        $this->assertEquals(count($response->json('data')), Notes::where('state', 'active')->count());
    }

    public function test_get_archived_notes()
    {
        Notes::factory()->count(10)->create();
        $response = $this->get('/api/v1/notes/archived');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'content',
                    'state',
                    'setted'
                ]
            ]
        ]);

        $this->assertEquals(count($response->json('data')), Notes::where('state', 'archived')->count());
    }

    public function test_store_active_notes(): void
    {
        $payload = [
            'title' => $this->faker->word(),
            'content' => $this->faker->paragraph(),
            'state' => NoteStatesEnum::ACTIVE->value,
            'setted' => 1
        ];

        $response = $this->post('/api/v1/notes', $payload);
        $response->assertStatus(201);
        $response->assertJson([
            'status' => "OK",
            'message' => "Nota creada",
            'data' => [
                'id' => $response->json('data.id'),
                'title' => $payload['title'],
                'content' => $payload['content'],
                'state' => $payload['state'],
                'setted' => $payload['setted']
            ]
        ])->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'id',
                'title',
                'content',
                'state',
                'setted'
            ]
        ]);
    }

    public function test_update_note(): void
    {
        $note = Notes::factory()->create();
        $payload = [
            'title' => "updated",
        ];
        $response = $this->put("/api/v1/notes/{$note->id}", $payload);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => "OK",
            'message' => "Nota actualizada",
            'data' => [
                'title' => $payload['title'],
            ]
        ]);

        $this->assertDatabaseHas('notes', $payload);
    }

    public function test_delete_notes(): void
    {
        $note = Notes::factory()->create();
        $response = $this->delete("/api/v1/notes/{$note->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'status' => "OK",
            'message' => "Nota borrada",
            'data' => null
        ]);

        $this->assertDatabaseMissing('notes',  ['id' => $note->id]);
    }

    public function test_store_archive_note(): void
    {
        $note = Notes::factory()->create([
            'title' => $this->faker->word(),
            'content' => $this->faker->paragraph(),
            'state' => NoteStatesEnum::ACTIVE->value,
            'setted' => 1
        ]);
        $response = $this->post("/api/v1/notes/{$note->id}/archive");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);

        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'state' => NoteStatesEnum::ARCHIVED->value,
        ]);
    }
}
