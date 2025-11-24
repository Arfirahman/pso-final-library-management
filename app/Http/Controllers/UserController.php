<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display the User Dashboard (which acts as the Book Borrowing form and history).
     */
    public function index()
    {
        // Get available books
        $books = Book::where('available', '>', 0)->get();

        // Get the currently logged-in user's data from session
        $loggedInUserId = session('user_id');
        $loggedInUser = User::find($loggedInUserId);

        // Get all users with 'user' role for the dropdown (if still desired, though not recommended for personal dashboard)
        $users = User::where('role', 'user')->get();

        // NEW: Get borrowing history for the logged-in user
        // Order by borrow_date descending (latest first)
        $borrowingHistory = Borrow::with(['book']) // Eager load the book details
                                  ->where('user_id', $loggedInUserId)
                                  ->orderBy('borrow_date', 'desc')
                                  ->get();

        return view('user.dashboard', compact('books', 'loggedInUser', 'users', 'borrowingHistory')); // Pass borrowingHistory
    }

    /**
     * Store book borrowing data.
     */
    public function storeBorrow(Request $request)
    {
        // Validation input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
        ]);

        // Get user_id from the form
        $userIdFromForm = $request->user_id;

        // Find the selected book
        $book = Book::find($request->book_id);

        // Check if the book is available
        if (!$book || $book->available <= 0) {
            return redirect()->back()->with('error', 'Book is not available for borrowing.');
        }

        // Decrement book availability
        $book->decrement('available');

        // Store borrowing data
        Borrow::create([
            'user_id' => $userIdFromForm,
            'book_id' => $request->book_id,
            'borrow_date' => $request->borrow_date,
            'return_date' => null,
        ]);

        // Redirect to the confirmation page
        return redirect()->route('user.borrow.confirmation')->with('success', 'Book borrowing successfully recorded!');
    }

    /**
     * Display the borrowing confirmation page.
     */
    public function borrowConfirmation()
    {
        return view('user.borrow_confirmation');
    }
}
