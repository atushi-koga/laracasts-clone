<?php

namespace Tests\Unit;

use App\Lesson;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LessonTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGetNextLessonsFromLessons()
    {
        $lesson = factory(Lesson::class)->create([
            'episode_number' => 200
        ]);
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1,
            'episode_number' => 100
        ]);
        $lesson3 = factory(Lesson::class)->create([
            'series_id' => 1,
            'episode_number' => 300
        ]);

        $this->assertEquals($lesson->id, $lesson2->getNextLesson()->id);
        $this->assertEquals($lesson3->id, $lesson->getNextLesson()->id);
        $this->assertNull($lesson3->getNextLesson());
    }

    public function testCanGetPrevLessonsFromLessons()
    {
        $lesson = factory(Lesson::class)->create([
            'episode_number' => 200
        ]);
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1,
            'episode_number' => 100
        ]);
        $lesson3 = factory(Lesson::class)->create([
            'series_id' => 1,
            'episode_number' => 300
        ]);

        $this->assertEquals($lesson->id, $lesson3->getPrevLesson()->id);
        $this->assertEquals($lesson2->id, $lesson->getPrevLesson()->id);
        $this->assertNull($lesson2->getPrevLesson());
    }

}
