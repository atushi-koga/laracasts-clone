<?php

namespace Tests\Feature;

use App\Http\Requests\CreateLessonRequest;
use App\Series;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateLessonTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanCreateLesson()
    {
        $this->loginAdmin();
        $series = factory(Series::class)->create();
        $lesson = [
            'title' => 'new lesson',
            'description' => 'this is new lesson',
            'episode_number' => 123,
            'video_id' => '456',
        ];

        $this->postJson("/admin/{$series->id}/lessons", $lesson)
            ->assertStatus(201)
            ->assertJson($lesson);

        $this->assertDatabaseHas('lessons', [
            'title' => $lesson['title'],
            'description' => $lesson['description'],
            'episode_number' => $lesson['episode_number'],
            'video_id' => $lesson['video_id'],
        ]);
    }

    public function testTitleIsRequiredToCreateLesson()
    {
        $this->loginAdmin();
        $series = factory(Series::class)->create();
        $lesson = [
            'description' => 'this is new lesson',
            'episode_number' => 123,
            'video_id' => '456',
        ];

        $this->post("/admin/{$series->id}/lessons", $lesson)
            ->assertSessionHasErrors('title');
    }

    /**
     * @dataProvider CreateLessonProvider
     */
    public function testCreateLessonValidation($name, $value, $expectedResult, $expectedErrorMessage)
    {
        $request = new CreateLessonRequest();
        $data = [$name => $value];
        $rules = [$name => $request->rules()[$name]];
        $validator = Validator::make($data, $rules);

        $this->assertEquals($expectedResult, $validator->passes());

        $errorMessage = $validator->errors()->get($name);
        $errorMessage = array_shift($errorMessage);

        $this->assertEquals($errorMessage, $expectedErrorMessage);
    }

    public function CreateLessonProvider()
    {
        return [
            'title_required_false' => ['title', '', false, 'The title field is required.'],
            'title_required_true' => ['title', 'new lesson', true, null],
            'title_max_false' => ['title', '123456789012345678901', false, 'The title may not be greater than 20 characters.'],
            'title_max_true' => ['title', '12345678901234567890', true, null],
            'description_required_false' => ['description', '', false, 'The description field is required.'],
            'description_required_true' => ['description', 'this is new lesson', true, null],
        ];
    }

}
