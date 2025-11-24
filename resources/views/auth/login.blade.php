<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Digital Library Management System</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom styles for backdrop-blur on older browsers or for stronger blur effect if needed */
        .backdrop-blur-sm {
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }
        /* Basic focus ring reset for Tailwind consistent styling */
        input:focus, button:focus, select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.45); /* Equivalent to focus:ring-blue-500 */
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 flex items-center justify-center p-4">
    <div class="w-full max-w-6xl grid lg:grid-cols-2 gap-8 items-center">
        <!-- Left side - Illustration and branding -->
        <div class="hidden lg:flex flex-col items-center justify-center text-center space-y-6 p-8">
            <div class="relative">
                {{-- Replaced the large SVG icon with your custom PNG logo --}}
                <div class="w-32 h-32 flex items-center justify-center mb-6 shadow-2xl p-2 square-full bg-white/50"> {{-- Added some background and padding for the image container --}}
                    <img src="{{ asset('images/books_logo.png') }}" alt="Library Logo" class="max-w-full max-h-full object-contain">
                </div>
                {{-- The small floating Book Open icon is removed to simplify with single logo --}}
            </div>

            <div class="space-y-4">
                <h1 class="text-4xl font-bold text-gray-800">
                    Digital Library
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 block">
                        Management System
                    </span>
                </h1>
                <p class="text-lg text-gray-600 max-w-md">
                    Manage book borrowing online easily and efficiently.
                    Access thousands of digital book collections anytime, anywhere.
                </p>
            </div>

            <div class="grid grid-cols-3 gap-4 w-full max-w-md">
                <div class="text-center p-4 bg-white/50 rounded-lg shadow-md backdrop-blur-sm">
                    <!-- Book Open Icon (SVG) -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-open text-blue-600 mx-auto mb-2">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                    </svg>
                    <div class="text-2xl font-bold text-gray-800">5000+</div>
                    <div class="text-sm text-gray-600">Book Collections</div>
                </div>
                <div class="text-center p-4 bg-white/50 rounded-lg shadow-md backdrop-blur-sm">
                    <!-- Users Icon (SVG) -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users text-purple-600 mx-auto mb-2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    <div class="text-2xl font-bold text-gray-800">2000+</div>
                    <div class="text-sm text-gray-600">Active Members</div>
                </div>
                <div class="text-center p-4 bg-white/50 rounded-lg shadow-md backdrop-blur-sm">
                    <!-- Library Icon (SVG) -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-library text-indigo-600 mx-auto mb-2">
                        <path d="m16 6 4 14"/><path d="M12 6v14"/><path d="M8 8v12"/><path d="M4 4v16"/>
                        <path d="M12 2v20"/><path d="M4 2h16"/>
                    </svg>
                    <div class="text-2xl font-bold text-gray-800">24/7</div>
                    <div class="text-sm text-gray-600">Online Access</div>
                </div>
            </div>
        </div>

        <!-- Right side - Login form (Card replacement) -->
        <div class="flex items-center justify-center">
            <div class="w-full max-w-md bg-white/80 backdrop-blur-sm rounded-lg shadow-xl overflow-hidden">
                <div class="p-6 text-center space-y-2 pb-6">
                    {{-- Replaced the small SVG icon with your custom PNG logo for mobile view --}}
                    <div class="w-16 h-16 flex items-center justify-center mx-auto mb-4 lg:hidden p-1 rounded-full bg-white/50">
                        <img src="{{ asset('images/books_logo.png') }}" alt="Library Logo" class="max-w-full max-h-full object-contain">
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">
                        Log in to Your Account
                    </h2>
                    <p class="text-gray-600">
                        Please log in to access the digital library system
                    </p>
                </div>

                <div class="p-6 pt-0 space-y-6">
                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Email or Username
                            </label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                placeholder="enter your email or username"
                                value="{{ old('email') }}"
                                class="h-11 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                required
                            />
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                Password
                            </label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="enter your password"
                                class="h-11 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                                required
                            />
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        

                        <button
                            type="submit"
                            class="w-full h-11 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium rounded-lg transition-all duration-200 flex items-center justify-center space-x-2 shadow-md hover:shadow-lg"
                        >
                            <span>Log In</span>
                            <!-- Arrow Right Icon (SVG) -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right">
                                <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                            </svg>
                        </button>
                    </form>

                   
                </div>
            </div>
        </div>
    </div>
</body>
</html>
