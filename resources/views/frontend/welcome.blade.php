@extends('frontend.layouts.app')

@section('title', 'Welcome to ProsharPOS')

@section('content')
    @include('frontend.global_layout.header')
    @include('frontend.welcome_page.hero')
    @include('frontend.welcome_page.about')
    @include('frontend.welcome_page.features')
    @include('frontend.welcome_page.service')
    @include('frontend.welcome_page.improvement')
    @include('frontend.welcome_page.qa')
    @include('frontend.welcome_page.blog')
    @include('frontend.global_layout.footer')
@endsection
