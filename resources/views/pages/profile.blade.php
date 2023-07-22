@extends('layouts.app')

@section('content')
<div class="flex">
    @include('components.sidebar')
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-4">Profile Information</h1>
        <p class="text-lg">Name: {{ Auth::user()->name }}</p>
        <p class="text-lg mb-8">Email: {{ Auth::user()->email }}</p>
        <a href="{{ route('editProfile') }}" class="mt-8 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Edit Profile</a>
    </div>
</div>
@endsection
