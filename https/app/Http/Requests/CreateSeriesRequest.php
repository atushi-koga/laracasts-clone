<?php

namespace App\Http\Requests;

use App\Series;
use Illuminate\Foundation\Http\FormRequest;

class CreateSeriesRequest extends SeriesRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules['image'] = 'required|image';

        return $rules;
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

        return redirect()->route('series.show', $series->slug);
    }

    /**
     * Get the URL to redirect to on a validation error.
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        return route('series.create');
    }

}
