<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Student</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-6 text-center">
            Add New Student
        </h1>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.students.store') }}">
            @csrf
            <input type="hidden" name="academicYear" value="{{ $academicYear ?? 'primary1' }}">

            {{-- Student Name --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">
                    Student Name
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200"
                >
            </div>

            {{-- Student Phone --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">
                    Student Phone
                </label>
                <input
                    type="tel"
                    name="phone"
                    value="{{ old('phone') }}"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200"
                    placeholder="+20 10 1234 5678"
                >
            </div>

            {{-- Parent Phone --}}
            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">
                    Parent Phone
                </label>
                <input
                    type="tel"
                    name="parent_phone"
                    value="{{ old('parent_phone') }}"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200"
                    placeholder="+20 10 1234 5678"
                >
            </div>

            {{-- Submit --}}
            <div>
                <button
                    type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition"
                >
                    Create Student
                </button>
            </div>
        </form>
    </div>

</body>
</html>
