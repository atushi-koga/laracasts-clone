@extends('layouts.app')

@section('header')
<header class="header header-inverse" style="background-color: #9ac29d">
  <div class="container text-center">

    <div class="row">
      <div class="col-12 col-lg-8 offset-lg-2">

        <h1>{{ $lesson->title }}</h1>
        <p class="fs-20 opacity-70">{{ $series->title }}</p>

      </div>
    </div>

  </div>
</header>
@stop

@section('content')
  <div class="section bg-grey">
    <div class="container">
      <div class="row gap-y text-center">
        <div class="col-12">
          @php
            $prevLesson = $lesson->getPrevLesson();
            $nextLesson = $lesson->getNextLesson();
          @endphp
          <vue-player default_lesson="{{ $lesson }}"
                      @if($nextLesson)
                        next_lesson_url="{{ route('series.watch', ['series' => $series->slug, 'lesson' => $nextLesson->id]) }}"
                      @endif
          ></vue-player>
          @if($prevLesson)
            <a class="btn btn-info btn-lg pull-left" href="{{ route('series.watch', ['series' => $series->slug, 'lesson' => $prevLesson->id]) }}">Prev Lesson</a>
          @endif
          @if($nextLesson)
            <a class="btn btn-info btn-lg pull-right" href="{{ route('series.watch', ['series' => $series->slug, 'lesson' => $nextLesson->id]) }}">Next Lesson</a>
          @endif
        </div>
        <div class="col-12">
          <ul class="list-group">
          </ul>
        </div>
      </div>
    </div>

    <div class="col-12">
      <ul class="list-group">
        @foreach($series->getOrderedLessons() as $l)
          <li class="list-group-item"><a href="{{ route('series.watch', ['series' => $series->slug, 'lesson' => $l->id]) }}">{{ $l->title }}</a></li>
        @endforeach
      </ul>
    </div>
  </div>
@stop