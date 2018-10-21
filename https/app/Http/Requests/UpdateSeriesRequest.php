<?php

namespace App\Http\Requests;

use App\Series;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateSeriesRequest extends SeriesRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return parent::rules();
    }

    /**
     * Get the URL to redirect to on a validation error.
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        return route('series.edit', $this->series);
    }

    public function updateSeries($series)
    {
        if ($this->hasFile('image')) {
            $series->image_url = 'series/' . $this->uploadSeriesImage()->filename;
        }
        $series->title = $this->title;
        $series->slug = str_slug($this->title);
        $series->description = $this->description;

        $series->save();
    }

}
