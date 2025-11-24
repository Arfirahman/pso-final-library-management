<!DOCTYPE html>
<html>
<head>
    <title>Borrowing Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg text-center max-w-md mx-auto">
        <h1 class="text-3xl font-bold text-green-600 mb-4">Borrowing Successful!</h1>
        <p class="text-gray-700 text-lg mb-6">
            Thank you for borrowing this book.
            <br>
            Please proceed to the library to collect your physical book.
        </p>
        <p class="text-gray-600 text-sm mb-8">
            (You can find the library address and operating hours on our main website.)
        </p>
        <a href="{{ route('user.dashboard') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
            Borrow Another Book
        </a>
        <form action="{{ route('logout') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold">Logout</button>
        </form>
    </div>
</body>
</html>
