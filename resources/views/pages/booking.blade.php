@extends('layouts.app')

@section('content')
<div class="flex">
    @include('components.sidebar')
    <div class="flex-1 p-4">
        <h1 class="text-3xl font-bold mb-4">Riwayat Pemesanan</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($bookings as $booking)
            <div class="bg-white shadow-md p-4 rounded-lg">
                <p class="mb-2">Id Booking: {{ $booking['id'] }}</p>
                <p class="mb-2">Status pembayaran:
                    @if($booking['status'] === 'paid')
                        Lunas
                    @elseif($booking['status'] === 'booked')
                        Menunggu Pembayaran
                    @elseif($booking['status'] === 'cancelled')
                        Dibatalkan
                    @else
                        Belum Dibayar
                    @endif
                </p>
                <p class="mb-2">Origin: {{ $booking->travel->origin }}</p>
                <p class="mb-2">Price: {{ $booking->travel->price }}</p>
                <p class="mb-2">Departure Time: {{ $booking->travel->departure_time }}</p>
                <p class="mb-2">Booked at: {{ $booking['created_at'] }}</p>
                
                <!-- Cancel Booking form -->
                <form action="{{ route('cancelBooking', ['bookingId' => $booking['id']]) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg mt-4 inline-block">
                        Batalkan
                    </button>
                </form>

                <!-- Pay Booking form -->
                <form action="{{ route('payBooking', ['bookingId' => $booking['id']]) }}" method="post">
                    @csrf
                    <input type="hidden" name="stripe_token" value="tok_visa">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg mt-4 inline-block ml-2">
                        Bayar
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</div>
</div>
@endsection
