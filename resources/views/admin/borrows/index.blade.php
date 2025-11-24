<!DOCTYPE html>
<html>
<head>
    <title>Admin - Borrowing History</title>
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

        <nav class="mb-8 bg-white p-4 rounded-lg shadow-md">
            <ul class="flex space-x-6">
                <li><a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-blue-800 font-semibold">Dashboard</a></li>
                <li><a href="{{ route('admin.books.index') }}" class="text-gray-500 hover:text-blue-800 font-semibold">Manage Books</a></li>
                <li><a href="{{ route('admin.borrows.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Borrowing History</a></li>
                <li><a href="{{ route('admin.users.create') }}" class="text-gray-500 hover:text-blue-800 font-semibold">Add User</a></li>
                <li><a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-blue-800 font-semibold">User List</a></li>
            </ul>
        </nav>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Borrowing History</h2>
            </div>

            @if($borrows->isEmpty())
                <p class="text-gray-600">No borrowing records found.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">ID</th>
                                <th class="py-2 px-4 border-b">User Name</th>
                                <th class="py-2 px-4 border-b">User Email</th> {{-- Kolom baru: User Email --}}
                                <th class="py-2 px-4 border-b">Book Title</th>
                                <th class="py-2 px-4 border-b">Borrow Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($borrows as $borrow)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $borrow->id }}</td>
                                    <td class="py-2 px-4 border-b">{{ $borrow->user->name ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $borrow->user->email ?? 'N/A' }}</td> {{-- Menampilkan email user --}}
                                    <td class="py-2 px-4 border-b">{{ $borrow->book->title ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $borrow->borrow_date }}</td>
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
