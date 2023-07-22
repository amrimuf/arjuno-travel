@extends('layouts.app')

@section('content')
<div class="flex">
    @include('components.sidebar')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-4">Edit Profile</h1>
        <form action="{{ route('updateProfile') }}" method="post" class="max-w-md">
            @csrf
            <div class="mb-4">
                <label for="name" class="block font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="email" class="block font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <button type="submit" class="bg-indigo-600 text-white font-semibold px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50">Update Profile</button>
        </form>
    </div>
</div>
@endsection
