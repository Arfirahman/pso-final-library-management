<!DOCTYPE html>
<html>
<head>
    <title>Manage Books - Admin</title>
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
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Book List</h2>
                <a href="{{ route('admin.books.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add New Book</a>
            </div>
            
            @if($books->isEmpty())
                <p class="text-gray-600">No books in the library.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">ID</th>
                                <th class="py-2 px-4 border-b">Title</th>
                                <th class="py-2 px-4 border-b">Author</th>
                                <th class="py-2 px-4 border-b">Year</th>
                                <th class="py-2 px-4 border-b">Available</th>
                                <th class="py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $book->id }}</td>
                                    <td class="py-2 px-4 border-b">{{ $book->title }}</td>
                                    <td class="py-2 px-4 border-b">{{ $book->author }}</td>
                                    <td class="py-2 px-4 border-b">{{ $book->year }}</td>
                                    <td class="py-2 px-4 border-b">{{ $book->available }}</td>
                                    <td class="py-2 px-4 border-b flex space-x-2">
                                        <a href="{{ route('admin.books.edit', $book->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white text-sm py-1 px-3 rounded">Edit</a>
                                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-sm py-1 px-3 rounded">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
