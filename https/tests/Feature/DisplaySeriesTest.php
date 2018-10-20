<?php

namespace Tests\Feature;

use App\Series;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DisplaySeriesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->loginAdmin();
    }

    public function testCanSeeCreatedSeriesTitle()
    {
        $series = factory(Series::class)->create();

        $this->get(route('series.show', $series->slug))
            ->assertStatus(200)
            ->assertSee($series->title);
    }
}
