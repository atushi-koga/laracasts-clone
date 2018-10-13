<?php

namespace App\Http\Requests;

use App\Series;
use Illuminate\Foundation\Http\FormRequest;

class CreateSeriesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image',
        ];
    }

    public function uploadSeriesImage()
    {
        $uploadedImage = $this->image;
        $this->filename = str_slug($this->title) . '.' . $uploadedImage->getClientOriginalExtension();

        $uploadedImage->storePubliclyAs('series', $this->filename);

        return $this;
    }

    public function storeSeries()
    {
        $series = Series::create([

            'title' => $this->title,
            'slug' => str_slug($this->title),
            'image_url' => 'series/' . $this->filename,
            'description' => $this->description,

        ]);

        session()->flash('success', 'Series created successfully');

        return redirect()->route('series.show', $series->id);
    }

}
