<?php

namespace Tests\Feature;

use App\Models\Notes;
use Tests\TestCase;

class NotesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
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
}
