<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateSeriesTest extends TestCase
{
    use RefreshDatabase;

    public function testCanDisplayCreateForm()
    {
        $this->get(route('series.create'))
            ->assertStatus(200)
            ->assertSee('Create a bahd series');
    }

    public function testCanCreateSeries()
    {
        Storage::fake();
        $title = 'new series';
        $description = 'new series description';
        $imageName = str_slug($title) . '.jpg';

        $this->post(route('series.store'), [

            'title' => $title,
            'image' => UploadedFile::fake()->image($imageName),
            'description' => $description,

        ])->assertRedirect()
            ->assertSessionHas('success', 'Series created successfully');

        Storage::assertExists('series/' . $imageName);

        $this->assertDatabaseHas('series', [

            'title' => $title,
            'slug' => str_slug($title),
            'image_url' => 'series/' . $imageName,
            'description' => $description,

        ]);
    }

    public function testSeriesMustBeCreatedWithATitle()
    {
        Storage::fake();

        $this->post(route('series.store'), [

            'image' => UploadedFile::fake()->image('image-series.jpg'),
            'description' => 'series description',

        ])->assertSessionHasErrors('title');
    }

    public function testSeriesMustBeCreatedWithADescription()
    {
        Storage::fake();

        $this->post(route('series.store'), [

            'title' => 'series title',
            'image' => UploadedFile::fake()->image('image-series.jpg'),

        ])->assertSessionHasErrors('description');
    }

    public function testSeriesMustBeCreatedWithAnImage()
    {
        $this->post(route('series.store'), [

            'title' => 'series title',
            'description' => 'series description',

        ])->assertSessionHasErrors('image');
    }

    public function testSeriesMustBeCreatedWithAnImageFile()
    {
        $this->post(route('series.store'), [

            'title' => 'series title',
            'description' => 'series description',
            'image' => 'string',

        ])->assertSessionHasErrors('image');
    }

}
