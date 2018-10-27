<?php

namespace Tests\Feature;

use App\Lesson;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WatchSeriesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->flushRedis();
    }

    public function testUserCanCompleteSeries()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1,
        ]);

        $response = $this->post("/series/complete-lesson/{$lesson->id}", []);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'ok',
        ]);

        $this->assertTrue($user->hasCompletedLesson($lesson));
        $this->assertFalse($user->hasCompletedLesson($lesson2));
    }
}
