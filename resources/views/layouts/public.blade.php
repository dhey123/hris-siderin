<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Karier | PT Quantum Tosan International')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    {{-- HEADER --}}
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-lg font-bold text-green-600">
                {{ config('app_name', 'HRIS') }}
            </h1>
            <a href="{{ route('career.index') }}"
               class="text-sm text-gray-600 hover:text-green-600">
                Lowongan
            </a>
        </div>
    </header>

    {{-- CONTENT --}}
    <main class="max-w-7xl mx-auto px-4 py-6">
        @yield('content')
    </main>

     {{-- FOOTER --}}
    <footer class="bg-white border-t">
        <div class="max-w-7xl mx-auto px-6 py-4 text-center text-sm text-gray-500">
            © {{ date('Y') }} <span class="font-medium text-gray-700">
                PT Quantum Tosan International
            </span>. All rights reserved.
        </div>
    </footer>

</body>
</html>