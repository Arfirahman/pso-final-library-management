<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .nav-link.active {
            background-color: #e0f2fe; /* light-blue-100 */
            color: #1e40af; /* blue-800 */
            font-weight: 600; /* font-semibold */
            border-radius: 0.5rem; /* rounded-lg */
        }
        .card-stats {
            background-color: white;
            border-radius: 0.5rem; /* rounded-lg */
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); /* shadow-md */
            padding: 1.5rem; /* p-6 */
        }
        .activity-item {
            background-color: #f9fafb; /* gray-50 */
            border: 1px solid #e5e7eb; /* gray-200 */
            border-radius: 0.5rem; /* rounded-lg */
            padding: 0.75rem; /* p-3 */
        }
        .gradient-button {
            background-image: linear-gradient(to right, var(--tw-gradient-stops));
            --tw-gradient-stops: #3b82f6, #8b5cf6; /* from-blue-500 to-purple-600 */
        }
        .gradient-button-secondary {
            background-image: linear-gradient(to right, var(--tw-gradient-stops));
            --tw-gradient-stops: #a855f7, #6b21a8; /* from-purple-500 to-purple-800 */
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center space-x-2">
                <!-- Library Icon for Header -->
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-library text-blue-600">
                    <path d="m16 6 4 14"/><path d="M12 6v14"/><path d="M8 8v12"/><path d="M4 4v16"/>
                    <path d="M12 2v20"/><path d="M4 2h16"/>
                </svg>
                <span>Admin Dashboard</span>
            </h1>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg flex items-center space-x-2">
                    <!-- Logout Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="17 16 22 12 17 8"/><line x1="22" x2="11" y1="12" y2="12"/>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>

        <!-- Admin Navigation -->
        <nav class="mb-8 bg-white p-2 rounded-lg shadow-md flex space-x-2">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} py-2 px-4">Dashboard</a>
            <a href="{{ route('admin.books.index') }}" class="nav-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }} py-2 px-4">Manage Books</a>
            <a href="{{ route('admin.borrows.index') }}" class="nav-link {{ request()->routeIs('admin.borrows.*') ? 'active' : '' }} py-2 px-4">Borrowing History</a>
            <a href="{{ route('admin.users.create') }}" class="nav-link {{ request()->routeIs('admin.users.create') ? 'active' : '' }} py-2 px-4">Add User</a>
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.index') || request()->routeIs('admin.users.edit') ? 'active' : '' }} py-2 px-4">User List</a>
        </nav>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="card-stats flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-700 mb-1">Total Books</h2>
                    <p class="text-4xl font-bold text-blue-600">{{ $totalBooks }}</p>
                </div>
                <!-- Book Open Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-open text-blue-400 opacity-70">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                </svg>
            </div>
            <div class="card-stats flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-700 mb-1">Total Users</h2>
                    <p class="text-4xl font-bold text-green-600">{{ $totalUsers }}</p>
                </div>
                <!-- Users Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users text-green-400 opacity-70">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="card-stats flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-700 mb-1">Total Admins</h2>
                    <p class="text-4xl font-bold text-purple-600">{{ $totalAdmins }}</p>
                    <p class="text-sm text-gray-500">Active</p>
                </div>
                <!-- User Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user text-purple-400 opacity-70">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <div class="card-stats flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-700 mb-1">Total Borrows</h2>
                    <p class="text-4xl font-bold text-orange-600">{{ $totalBorrows }}</p>
                </div>
                <!-- Trending Up Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up text-orange-400 opacity-70">
                    <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/>
                </svg>
            </div>
        </div>

        <!-- Welcome and Recent Activities Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Welcome Card -->
            <div class="card-stats p-8">
                <div class="flex items-center space-x-3 mb-4">
                    <!-- User Round Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round text-blue-600">
                        <circle cx="12" cy="8" r="5"/><path d="M2 21a8 8 0 0 1 16 0"/>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-800">Welcome, Admin!</h2>
                </div>
                <p class="text-gray-700 text-lg mb-6">Manage your digital library system. You can add new books, view borrowing history, manage users, and monitor system activities.</p>

                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('admin.books.index') }}" class="gradient-button text-white font-bold py-3 px-6 rounded-lg text-center flex items-center justify-center space-x-2 hover:opacity-90 transition-opacity">
                        <!-- Book Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book">
                            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/>
                        </svg>
                        <span>Manage Books</span>
                    </a>
                    
                </div>
            </div>

            <!-- Recent Activities Card -->
            <div class="card-stats p-8">
                <div class="flex items-center space-x-3 mb-4">
                    <!-- Activity Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-activity text-orange-600">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-800">Recent Activities</h2>
                </div>
                <p class="text-gray-600 text-lg mb-6">Monitor real-time user activities.</p>

                @if($recentActivities->isEmpty())
                    <p class="text-gray-600">No recent activities found.</p>
                @else
                    <div class="space-y-4">
                        @foreach($recentActivities as $activity)
                            <div class="activity-item flex items-start space-x-3">
                                <!-- Check Circle Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle text-green-500 flex-shrink-0 mt-1">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/>
                                </svg>
                                <div class="flex-grow">
                                    <p class="text-gray-800 font-medium">
                                        <span class="font-semibold">{{ $activity->user->name ?? 'Unknown User' }}</span> borrowed
                                        <span class="font-semibold">{{ $activity->book->title ?? 'Unknown Book' }}</span>
                                    </p>
                                    <p class="text-sm text-gray-500">{{ $activity->created_at->diffForHumans() }} ago</p>
                                </div>
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-medium whitespace-nowrap">Success</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
