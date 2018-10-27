<?php

namespace Tests\Unit;

use App\Lesson;
use App\Series;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeriesTest extends TestCase
{
    use RefreshDatabase;

    public function testImagePath()
    {
        $series = factory(Series::class)->create([
            'image_url' => 'series/ultimate-laravel.png',

        ]);

        $this->assertEquals(asset('storage/series/ultimate-laravel.png'), $series->image_path);
    }

    public function testCanGetOrderedLessons()
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

        $orderedLessons = $lesson->series->getOrderedLessons();

        $this->assertInstanceOf(Lesson::class, $orderedLessons->random());
        $this->assertEquals($lesson2->id, $orderedLessons->first()->id);
        $this->assertEquals($lesson3->id, $orderedLessons->last()->id);
    }
}
