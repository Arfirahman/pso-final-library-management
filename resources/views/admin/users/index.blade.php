<!DOCTYPE html>
<html>
<head>
    <title>Admin - User List</title>
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
                <li><a href="{{ route('admin.borrows.index') }}" class="text-gray-500 hover:text-blue-800 font-semibold">Borrowing History</a></li>
                <li><a href="{{ route('admin.users.create') }}" class="text-gray-500 hover:text-blue-800 font-semibold">Add User</a></li>
                <li><a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">User List</a></li> {{-- Active link --}}
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
                <h2 class="text-2xl font-bold text-gray-800">User List</h2>
                <a href="{{ route('admin.users.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add New User</a>
            </div>
            
            @if($users->isEmpty())
                <p class="text-gray-600">No users found.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">ID</th>
                                <th class="py-2 px-4 border-b">Name</th>
                                <th class="py-2 px-4 border-b">Email</th>
                                <th class="py-2 px-4 border-b">Role</th>
                                <th class="py-2 px-4 border-b">Age</th>
                                <th class="py-2 px-4 border-b">Phone Number</th>
                                <th class="py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $user->id }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                                    <td class="py-2 px-4 border-b">{{ ucfirst($user->role) }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->age ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->phone_number ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border-b flex space-x-2">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white text-sm py-1 px-3 rounded">Edit</a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
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
