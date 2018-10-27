<?php

namespace Tests\Unit;

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
}
