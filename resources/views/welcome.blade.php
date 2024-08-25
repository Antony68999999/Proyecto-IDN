<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Plataforma para tickests de soporte</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">

    <!-- TailwindCSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">

    <!-- Your custom styles -->
    <style>
        body {
            font-family: 'Figtree', ui-sans-serif, system-ui, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            margin: 0;
            line-height: inherit;
            background-color: #1a202c; /* Night blue background color */
            color: #e2e8f0; /* Light text color */
        }
        .header-bg {
            background-color: #2d3748; /* Darker blue for header */
            padding: 3rem 0; /* Vertical padding */
        }
        h1 {
            font-size: 3rem; /* Larger font size for title */
            text-align: center; /* Center text */
            margin-top: 2rem; /* Top margin */
            margin-bottom: 2rem; /* Bottom margin */
            color: #ffffff; /* White text color */
        }
        nav {
            position: relative;
            z-index: 1; /* Ensure links are clickable over the background */
            background-image: url('https://example.com/support-ticket-icon.png'); /* Replace with your ticket support icon */
            background-size: cover;
            background-position: center;
            padding: 10px; /* Padding around the background */
        }
        nav a {
            font-size: 1.5rem; /* Larger font size for links */
            margin: 0 10px; /* Spacing between links */
            color: #fff; /* White text color */
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
            padding: 8px 16px; /* Padding around links */
            border-radius: 8px; /* Rounded corners */
            transition: background-color 0.3s ease;
        }
        nav a:hover {
            background-color: rgba(0, 0, 0, 0.7); /* Darker background on hover */
        }
    </style>
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="bg-gray-200 text-black/50 dark:bg-black dark:text-white/50 min-h-screen flex flex-col justify-center items-center">
        <header class="w-full header-bg">
            <nav class="max-w-7xl mx-auto px-6 lg:px-8 py-4 flex justify-center lg:justify-end">
                @auth
                    <a href="{{ url('/dashboard') }}" class="rounded-md transition hover:bg-[#FF2D20] focus:outline-none focus-visible:ring-[#FF2D20]">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="rounded-md transition hover:bg-[#FF2D20] focus:outline-none focus-visible:ring-[#FF2D20]">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="rounded-md transition hover:bg-[#FF2D20] focus:outline-none focus-visible:ring-[#FF2D20]">Registro</a>
                    @endif
                @endauth
            </nav>
        </header>
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-4 flex flex-col items-center justify-center h-full">
           <br> <h1 class="text-4xl font-bold text-center">PLATAFORMA PARA TICKESTS DE SOPORTE <br>IDN</h1>
        </div>
    </div>
</body>
</html>
