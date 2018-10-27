<?php

namespace App\Entities;

use App\Lesson;
use Redis;

trait Learning
{

    /**
     * @param $lesson
     */
    public function completeLesson($lesson)
    {
        Redis::sadd("user:{$this->id}:series:{$lesson->series->id}", $lesson->id);
    }

    /**
     * @param $series
     * @return float|int
     */
    public function getCompletedLessonsPercentage($series)
    {
        $numberOfLessonsInSeries = $series->lessons->count();
        $numberOfCompletedLessons = $this->getNumberOfCompletedLessons($series);

        return ($numberOfCompletedLessons / $numberOfLessonsInSeries) * 100;
    }

    /**
     * @param $series
     * @return int
     */
    public function getNumberOfCompletedLessons($series)
    {
        return count($this->getCompletedLessonsIds($series));
    }

    /**
     * @param $series
     * @return bool
     */
    public function hasStartedSeries($series)
    {
        return $this->getNumberOfCompletedLessons($series) > 0;
    }

    /**
     * @param $series
     * @return array
     */
    public function getCompletedLessonsIds($series)
    {
        return Redis::smembers("user:{$this->id}:series:{$series->id}");
    }

    public function getCompletedLessons($series)
    {
        return Lesson::whereIn('id', $this->getCompletedLessonsIds($series))->get();
    }

}