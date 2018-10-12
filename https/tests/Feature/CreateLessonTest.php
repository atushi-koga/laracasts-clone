<?php

namespace Tests\Feature;

use App\Series;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateLessonTest extends TestCase
{
    use RefreshDatabase;

    public  function testUserCanCreateLesson()
    {
        $this->loginAdmin();
        $series = factory(Series::class)->create();
        $lesson = [
            'title' => 'new lesson',
            'description' => 'this is new lesson',
            'episode_number' => 123,
            'video_id' => '456',
        ];

        $this->postJson("/admin/{$series->id}/lessons", $lesson)
            ->assertStatus(201)
            ->assertJson($lesson);

        $this->assertDatabaseHas('lessons', [
            'title' => $lesson['title'],
            'description' => $lesson['description'],
            'episode_number' => $lesson['episode_number'],
            'video_id' => $lesson['video_id'],
        ]);
    }

    public function testTitleIsRequiredToCreateLesson()
    {
        $this->loginAdmin();
        $series = factory(Series::class)->create();
        $lesson = [
            'description' => 'this is new lesson',
            'episode_number' => 123,
            'video_id' => '456',
        ];

        $this->post("/admin/{$series->id}/lessons", $lesson)
            ->assertSessionHasErrors('title');
    }

    public function testDescriptionIsRequiredToCreateLesson()
    {
        $this->loginAdmin();
        $series = factory(Series::class)->create();
        $lesson = [
            'title' => 'new lesson',
            'episode_number' => 123,
            'video_id' => '456',
        ];

        $this->post("/admin/{$series->id}/lessons", $lesson)
            ->assertSessionHasErrors('description');
    }

    public function testEpisodeNubmerIsRequiredToCreateLesson()
    {
        $this->loginAdmin();
        $series = factory(Series::class)->create();
        $lesson = [
            'title' => 'new lesson',
            'description' => 'this is new lesson',
            'video_id' => '456',
        ];

        $this->post("/admin/{$series->id}/lessons", $lesson)
            ->assertSessionHasErrors('episode_number');
    }
}
