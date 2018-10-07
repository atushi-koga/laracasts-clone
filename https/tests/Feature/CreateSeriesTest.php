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

        ])->assertRedirect();

        Storage::assertExists('series/' . $imageName);

        $this->assertDatabaseHas('series', [

            'title' => $title,
            'slug' => str_slug($title),
            'image_url' => 'series/' . $imageName,
            'description' => $description,

        ]);
    }
}
