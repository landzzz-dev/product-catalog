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
            ['label' => 'Name', 'name' => 'name'],
            ['label' => 'Username', 'name' => 'username'],
            ['label' => 'Password', 'name' => 'password'],
            ['label' => 'Confirm Password', 'name' => 'password_confirmation'],
        ]
    @endphp
    <div class="w-[360px] sm:w-[400px] grid gap-4 p-8 shadow-lg border rounded-xl">
        <p class="text-2xl font-bold text-center">Register your account</p>
        <form action="{{ route('register') }}" method="POST" class="grid gap-4">
            @csrf
            @foreach ($userCredential as $user)
                <div>
                    <label for="{{ $user['name'] }}">{{ $user['label'] }} <span class="text-pink-500">*</span></label>
                    <input class="input" type="text" name="{{ $user['name'] }}">
                    @error($user['name'])
                        <p class="text-pink-500">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach
            <button class="success mt-4">Register</button>
            <div class="mt-2">Already have an account? 
                <a href="{{ route('login') }}" class="text-blue-600 text-decoration-underline">Login here</a>
            </div>
        </form>
    </div>
</body>
</html>