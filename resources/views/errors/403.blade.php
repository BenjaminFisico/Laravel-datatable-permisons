@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message')
    {{__($exception->getMessage() ?: 'Forbidden')}}
    <br>
    <a href="{{route('dashboard')}}" style="color:aquamarine">GO TO DASHBOARD</a>
@endsection
