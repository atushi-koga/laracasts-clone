<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSeriesRequest;
use App\Http\Requests\UpdateSeriesRequest;
use App\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.series.all')->withSeries(Series::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.series.create');
    }

    /**
     * @param CreateSeriesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateSeriesRequest $request)
    {
        return $request->uploadSeriesImage()
            ->storeSeries();
    }

    /**
     * @param Series $series
     * @return mixed
     */
    public function show(Series $series)
    {
        return view('admin.series.index')
            ->withSeries($series);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Series $series
     * @return mixed
     */
    public function edit(Series $series)
    {
        return view('admin.series.edit')
            ->withSeries($series);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSeriesRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateSeriesRequest $request, Series $series)
    {
        $request->updateSeries($series);

        session()->flash('success', 'Series updated successfully');

        return redirect()->route('series.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
