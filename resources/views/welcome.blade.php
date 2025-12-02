@extends('layouts.app')

@section('title', 'Welcome to ProsharPOS')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

@section('content')
    @include('welcome_page.header')
    @include('welcome_page.banner')
    @include('welcome_page.about')
    @include('welcome_page.features')
    @include('welcome_page.service')
    @include('welcome_page.client_feedback')
    @include('welcome_page.qa')
    @include('welcome_page.blog')
    @include('welcome_page.footer')
@endsection
