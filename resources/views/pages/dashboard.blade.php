@extends('layouts.app')

@section('content')
    <div class="flex">
        @include('components.sidebar')
        <div class="flex-1 p-4">
            <h1 class="text-3xl font-bold mb-4">Cari Travel</h1>

            <!-- Filter Form -->
            <form id="filterForm" class="mb-4">
                <div class="flex items-center">
                    <label for="price" class="mr-2">Filter by Price:</label>
                    <input type="number" id="price" name="price" class="rounded-lg px-2 py-1 border" placeholder="Enter price">
                </div>
                <div class="flex items-center mt-2">
                    <label for="origin" class="mr-2">Filter by Origin:</label>
                    <input type="text" id="origin" name="origin" class="rounded-lg px-2 py-1 border" placeholder="Enter origin/destination">
                </div>
                <div class="flex items-center mt-2">
                    <label for="destination" class="mr-2">Filter by Destination:</label>
                    <input type="text" id="destination" name="destination" class="rounded-lg px-2 py-1 border" placeholder="Enter origin/destination">
                </div>
                <div class="flex items-center mt-2">
                    <label for="departure_time" class="mr-2">Filter by Departure Time:</label>
                    <input type="datetime-local" id="departure_time" name="departure_time" class="rounded-lg px-2 py-1 border">
                </div>
                <button type="button" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg mt-2" onclick="applyFilters()">Filter</button>
            </form>


            <!-- List of Travels -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($travels as $travel)
                    <div class="bg-white shadow-md p-4 rounded-lg">
                        <h4 class="text-lg font-semibold mb-2">{{ $travel['origin'] }} -  {{ $travel['destination'] }}</h4>
                        <p class="mb-2">Rp{{ $travel['price'] }}</p>
                        <p class="mb-2">Departure Time: {{ $travel['departure_time'] }}</p>
                        @if (Auth::user()->role !== 1) <!-- Only show the "Book" button if the user's role is not "admin" (assuming "admin" has role ID 1) -->
                            <form action="{{ route('bookTravel', ['id' => $travel['id']]) }}" method="post">
                                @csrf
                                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg mt-2">Book</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function applyFilters() {
            const price = document.getElementById('price').value;
            const origin = document.getElementById('origin').value;
            const destination = document.getElementById('destination').value;
            const departureTime = document.getElementById('departure_time').value;

            const baseUrl = '{{ route('dashboard') }}'; 
            const url = new URL(baseUrl);
            const params = new URLSearchParams();
            if (price) params.append('price', price);
            if (origin) params.append('origin', origin);
            if (destination) params.append('destination', destination);
            if (departureTime) params.append('departure_time', departureTime);
            url.search = params.toString();

            window.location.href = url.toString();
        }
    </script>
@endsection
