<?php

namespace Tests\Unit;

use App\Lesson;
use App\Series;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Artisan;
use Redis;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->flushRedis();
    }

    public function testUserCanCompleteLesson()
    {
        $user = factory(User::class)->create();
        $lesson1 = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1,
        ]);

        $user->completeLesson($lesson1);
        $user->completeLesson($lesson2);

        $this->assertEquals(Redis::smembers('user:1:series:1'), [1, 2]);
    }

    public function testCanGetCompletedLessonsPercentage()
    {
        $user = factory(User::class)->create();
        $lesson1 = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1,
        ]);
        factory(Lesson::class)->create([
            'series_id' => 1,
        ]);
        factory(Lesson::class)->create([
            'series_id' => 1,
        ]);

        $user->completeLesson($lesson1);
        $user->completeLesson($lesson2);

        $this->assertEquals(50, $user->getCompletedLessonsPercentage($lesson1->series));
    }

    public function testCanGetNumberOfCompletedLessons()
    {
        $user = factory(User::class)->create();
        $lesson1 = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1,
        ]);

        $user->completeLesson($lesson1);
        $user->completeLesson($lesson2);

        $this->assertEquals(2, $user->getNumberOfCompletedLessons($lesson1->series));
    }

    public function testCanKnowIfUserHaveStartedSeries()
    {
        $user = factory(User::class)->create();
        $lesson1 = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1,
        ]);
        $lesson3 = factory(Lesson::class)->create();

        $user->completeLesson($lesson1);

        $this->assertTrue($user->hasStartedSeries($lesson1->series));
        $this->assertFalse($user->hasStartedSeries($lesson3->series));
    }

    public function testCanGetCompletedLessons()
    {
        $user = factory(User::class)->create();
        $lesson1 = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1,
        ]);
        $lesson3 = factory(Lesson::class)->create([
            'series_id' => 1,
        ]);

        $user->completeLesson($lesson1);
        $user->completeLesson($lesson2);

        $completedLesson = $user->getCompletedLessons($lesson1->series);
        $completedLessonIds = $completedLesson->pluck('id')->all();

        $this->assertTrue(in_array($lesson1->id, $completedLessonIds));
        $this->assertTrue(in_array($lesson2->id, $completedLessonIds));
        $this->assertFalse(in_array($lesson3->id, $completedLessonIds));
    }

    public function testUserHasCompletedLesson()
    {
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1,
        ]);

        $user->completeLesson($lesson);

        $this->assertTrue($user->hasCompletedLesson($lesson));
        $this->assertFalse($user->hasCompletedLesson($lesson2));
    }

    public function testCanGetBeingWatchedLessonByUser()
    {
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1,
        ]);
        $lesson3 = factory(Lesson::class)->create();
        $lesson4 = factory(Lesson::class)->create([
            'series_id' => 2,
        ]);
        $lesson5 = factory(Lesson::class)->create();
        $lesson6 = factory(Lesson::class)->create([
            'series_id' => 3,
        ]);

        $user->completeLesson($lesson);
        $user->completeLesson($lesson3);

        $seriesBeingWatched = $user->getSeriesBeingWatched();

        $this->assertInstanceOf(Collection::class, $seriesBeingWatched);
        $this->assertInstanceOf(Series::class, $seriesBeingWatched->random());

        $idsOfSeriesBeingWatched = $seriesBeingWatched->pluck('id')->all();

        $this->assertTrue(in_array($lesson->series->id, $idsOfSeriesBeingWatched));
        $this->assertTrue(in_array($lesson3->series->id, $idsOfSeriesBeingWatched));
        $this->assertFalse(in_array($lesson5->series->id, $idsOfSeriesBeingWatched));
    }

    public function testCanGetTotalNumberOfCompletedLessonsForUser()
    {
        $user = factory(User::class)->create();
        $lesson1 = factory(Lesson::class)->create();
        $lesson1_2 = factory(Lesson::class)->create([
            'series_id' => 1,
        ]);
        $lesson2 = factory(Lesson::class)->create();
        $lesson3_1 = factory(Lesson::class)->create();
        $lesson3_2 = factory(Lesson::class)->create([
            'series_id' => 3,
        ]);

        $user->completeLesson($lesson1);
        $user->completeLesson($lesson1_2);
        $user->completeLesson($lesson3_1);

        $this->assertEquals(3, $user->getTotalNumberOfCompletedLessons());
    }
}
