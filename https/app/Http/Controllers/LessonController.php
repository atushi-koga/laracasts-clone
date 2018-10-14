<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Lesson;
use App\Series;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Series $series
     * @param CreateLessonRequest $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(Series $series, CreateLessonRequest $request)
    {
        return $series->lessons()->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @param Series $series
     * @param Lesson $lesson
     * @param UpdateLessonRequest $request
     * @return null|static
     */
    public function update(Series $series, Lesson $lesson, UpdateLessonRequest $request)
    {
        $lesson->update($request->all());

        return $lesson->fresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Series $series, Lesson $lesson)
    {
        $lesson->delete();

        return response()->json(['status' => 'ok'], 200);
    }
}
