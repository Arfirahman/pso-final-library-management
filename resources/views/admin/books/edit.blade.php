<!DOCTYPE html>
<html>
<head>
    <title>Edit Book - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Logout</button>
            </form>
        </div>

        <!-- Admin Navigation -->
        <nav class="mb-8 bg-white p-4 rounded-lg shadow-md">
            <ul class="flex space-x-6">
                <li><a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-blue-800 font-semibold">Dashboard</a></li>
                <li><a href="{{ route('admin.books.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Manage Books</a></li>
                <li><a href="{{ route('admin.borrows.index') }}" class="text-gray-500 hover:text-blue-800 font-semibold">Borrowing History</a></li>
                <li><a href="{{ route('admin.users.create') }}" class="text-gray-500 hover:text-blue-800 font-semibold">Add User</a></li>
                <li><a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-blue-800 font-semibold">User List</a></li>
            </ul>
        </nav>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Edit Book</h2>
            <form action="{{ route('admin.books.update', $book->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Essential for UPDATE method --}}
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Book Title:</label>
                    <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror" value="{{ old('title', $book->title) }}" required>
                    @error('title')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="author" class="block text-gray-700 text-sm font-bold mb-2">Author:</label>
                    <input type="text" name="author" id="author" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('author') border-red-500 @enderror" value="{{ old('author', $book->author) }}" required>
                    @error('author')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="year" class="block text-gray-700 text-sm font-bold mb-2">Publication Year:</label>
                    <input type="number" name="year" id="year" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('year') border-red-500 @enderror" value="{{ old('year', $book->year) }}" required>
                    @error('year')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="available" class="block text-gray-700 text-sm font-bold mb-2">Quantity Available:</label>
                    <input type="number" name="available" id="available" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('available') border-red-500 @enderror" value="{{ old('available', $book->available) }}" required>
                    @error('available')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update Book</button>
                    <a href="{{ route('admin.books.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
