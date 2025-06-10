<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Catalog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-screen w-full content-center place-items-center">
    @php
        $userCredential = [
            ['label' => 'Username', 'name' => 'username'],
            ['label' => 'Password', 'name' => 'password'],
        ]
    @endphp
    <div class="w-[360px] sm:w-[400px] grid gap-4 p-8 shadow-lg border rounded-xl">
        <p class="text-2xl font-bold text-center">Welcome, Login your account</p>
        <form action="{{ route('login') }}" method="POST" class="grid gap-4">
            @csrf
            @foreach ($userCredential as $user)
                <div>
                    <label for="{{ $user['name'] }}">{{ $user['label'] }} <span class="text-pink-500">*</span></label>
                    <input class="input" type="text" name="{{ $user['name'] }}">
                    @error($user['name'])
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach
            <button class="success mt-4">Login</button>
            <div class="mt-2">Don't have an account? 
                <a href="{{ route('register') }}" class="text-blue-600 text-decoration-underline">Register here</a>
            </div>
        </form>
    </div>

    @if (session('success'))
        <div 
            id="success-alert" 
            class="bottom-4 right-4 fixed bg-green-500 text-white px-4 py-3 shadow-md rounded transition transform duration-700"
        >
            {{ session('success') }}
        </div>

        <script>
            setTimeout(function () {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.classList.add('translate-x-full', 'opacity-0');
                    setTimeout(() => alert.style.display = 'none', 700);
                }
            }, 3500)
        </script>
    @endif
</body>
</html>