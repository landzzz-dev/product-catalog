<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Catalog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="h-screen flex flex-col font-sans antialiased">
        <header class="h-14 top-0 sticky z-20 w-full bg-gradient-to-r from-green-300 to-red-300 content-center">
            <div class="container mx-auto flex items-center justify-between px-4">
                <div class="text-2xl truncate">
                    Product Catalog
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('home') }}" class="bg-gray-300 py-2 px-4 rounded-3xl hover:bg-gray-400 hover:text-white">Home</a>
                    <a href="{{ route('home') }}" class="bg-gray-300 py-2 px-4 rounded-3xl hover:bg-gray-400 hover:text-white">Logout</a>
                </div>
            </div>
        </header>

        @if (Route::is('home'))
            <main class="flex flex-1 gap-4 md:gap-10 justify-center items-center">
                <a href="{{ route('products.blade') }}"
                class="group relative rounded-2xl h-[400px] w-full md:w-1/2 lg:w-1/4 flex items-center justify-center overflow-hidden cursor-pointer laravel-blade-bg transition duration-300 ease-in-out hover:-translate-y-1 hover:scale-10">
                    <div class="absolute inset-0 bg-black/15 group-hover:bg-black/30 transition duration-300"></div>
                    <span class="relative z-10 text-white laravel-text-shadow text-2xl font-bold group-hover:underline">
                        CRUD with Blade
                    </span>
                </a>
                <a href="{{ route('products.vue') }}"
                class="group relative rounded-2xl h-[400px] w-full md:w-1/2 lg:w-1/4 flex items-center justify-center overflow-hidden cursor-pointer vuejs-bg transition duration-300 ease-in-out hover:-translate-y-1 hover:scale-10">
                    <div class="absolute inset-0 bg-black/15 group-hover:bg-black/30 transition duration-300"></div>
                    <span class="relative z-10 text-white vue-text-shadow text-2xl font-bold group-hover:underline">
                        CRUD with Vue
                    </span>
                </a>
            </main>
        @else
            <main>
                @yield('content')
            </main>
        @endif
    </div>
</body>
</html>

<style>
    html, body {
        padding: 0;
        margin: 0;
    }

    .laravel-text-shadow {
        text-shadow: 2px 2px #ff0000;
    }

    .vue-text-shadow {
        text-shadow: 2px 2px #00965F;
    }
</style>
