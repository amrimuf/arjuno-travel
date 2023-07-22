<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Arjuno Travel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite('resources/css/app.css')
    </head>
    <body>
        <header>
            <nav class="bg-pink-500 border-gray-200 px-4 lg:px-6 py-2.5 text-white">
                <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                    <a href="/" class="flex items-center">
                        <img src="https://cdn-icons-png.flaticon.com/512/8262/8262475.png" class="mr-3 h-6 sm:h-9" alt=" Logo" />
                        <span class="self-center text-xl font-semibold whitespace-nowrap">Arjuno Travel</span>
                    </a>
                    <div class="flex items-center lg:order-2">
                        @guest
                            <!-- Display "Log in" link if the user is not logged in -->
                            <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 focus:outline-none">Log in</a>
                        @else
                        <a href="{{ route('dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700  focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 focus:outline-none">Dashboard</a>
                            <!-- Display "Log out" link if the user is logged in -->
                            <a href="{{ route('logout') }}" class="bg-indigo-600 hover:bg-indigo-700  focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 focus:outline-none">Log out</a>

                        @endguest
                    
                        <button data-collapse-toggle="mobile-menu-2" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-white rounded-lg lg:hidden focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="mobile-menu-2" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
                        <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                            <li>
                                <a href="/" class="block py-2 pr-4 pl-3 text-white rounded bg-primary-700 lg:bg-transparent lg:text-primary-700 lg:p-0" aria-current="page">Beranda</a>
                            </li>
                            <li>
                                <a href="/api/documentation" class="block py-2 pr-4 pl-3 text-pink-200 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-white lg:p-0">Rute Perjalanan</a>
                            </li>
                            <li>
                                <a href="/api/documentation" class="block py-2 pr-4 pl-3 text-pink-200 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-white lg:p-0">Cara Pemesanan</a>
                            </li>
                            <li>
                                <a href="/api/documentation" class="block py-2 pr-4 pl-3 text-pink-200 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-white lg:p-0">Hubungi Kami</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
    </body>
</html>
