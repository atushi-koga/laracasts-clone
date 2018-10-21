<?php

namespace Tests\Feature;

use App\Series;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateSeriesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->loginAdmin();
    }

    public function testCanUpdateSeries()
    {
        $series = factory(Series::class)->create();

        $updatedSeries = [
            'title' => 'updated Title',
            'slug' => str_slug('updated Title'),
            'description' => 'updated description',
            'image_name' => str_slug('updated Title') . '.jpg'
        ];

        Storage::fake(config('filesystems.default'));
        $this->put(route('series.update', $series->slug), [
            'title' => $updatedSeries['title'],
            'description' => $updatedSeries['description'],
            'image' => UploadedFile::fake()->image($updatedSeries['image_name']),
        ])->assertSessionHas('success', 'Series updated successfully')
            ->assertRedirect(route('series.index'));

        Storage::disk(config('filesystems.default'))
            ->assertExists('series/' . $updatedSeries['image_name']);

        $this->assertDatabaseHas('series', [
            'title' => $updatedSeries['title'],
            'slug' => $updatedSeries['slug'],
            'description' => $updatedSeries['description'],
            'image_url' => 'series/' . $updatedSeries['image_name']
        ]);

    }

    public function testCanUpdateSeriesWithoutImage()
    {
        $series = factory(Series::class)->create();

        $updatedSeries = [
            'title' => 'updated title',
            'slug' => str_slug('updated title'),
            'description' => 'updated description',
        ];

        $this->put(route('series.update', $series->slug), [
            'title' => $updatedSeries['title'],
            'description' => $updatedSeries['description'],
        ])->assertRedirect(route('series.index'))
            ->assertSessionHas('success', 'Series updated successfully');

        Storage::assertMissing('series/' . str_slug($updatedSeries['title']) . '.jpg');

        $this->assertDatabaseHas('series', [
            'title' => $updatedSeries['title'],
            'slug' => $updatedSeries['slug'],
            'description' => $updatedSeries['description'],
            'image_url' => $series->image_url
        ]);
    }

    public function testCanNotUpdateWithoutTitle()
    {
        $series = factory(Series::class)->create();

        $updatedSeries = [
            'description' => 'updated description',
        ];

        $this->put(route('series.update', $series->slug), [
            'description' => $updatedSeries['description'],
        ])->assertSessionHasErrors('title')
            ->assertRedirect(route('series.edit', $series->slug));

        $this->assertDatabaseMissing('series', [
            'description' => $updatedSeries['description']
        ]);
    }
}
