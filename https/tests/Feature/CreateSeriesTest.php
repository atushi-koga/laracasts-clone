<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateSeriesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->loginAdmin();
    }

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

    public function testOnlyAdministratorCanCreateSeries()
    {
        $user = factory(User::class)->create([

            'email' => 'stbe51@gmail.com'

            ]
        );
        $this->actingAs($user);

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

    public function testNotAdministratorCanNotCreateSeries()
    {
        $user = factory(User::class)->create([

            'email' => 'not_administrator@gmail.com'

        ]);
        $this->actingAs($user);

        Storage::fake();
        $this->post(route('series.store'), [

            'title' => 'new series',
            'image' => UploadedFile::fake()->image('series-image.jpg'),
            'description' => 'new series description',

        ])->assertSessionHas('error', 'You are not authorized to perform this action');

    }

}
