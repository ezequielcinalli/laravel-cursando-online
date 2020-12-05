@extends('layouts.app')

@section('content')
    <course-detail-component
        :course='{{$course}}' 
        @if (Auth::user())
            @if (Auth::user()->admin === 1)
            admin={{auth()->user()->admin}}
            @endif
            login={{auth()->user()}}>
        @else >
        @endif    
    </course-detail-component>
@endsection
