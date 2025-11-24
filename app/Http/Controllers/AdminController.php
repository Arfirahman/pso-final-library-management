<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Borrow;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon; // Import Carbon untuk manipulasi tanggal

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function index()
    {
        // Calculate statistics
        $totalBooks = Book::count();
        $availableBooks = Book::sum('available');
        $totalBorrows = Borrow::count();
        $totalUsers = User::where('role', 'user')->count();
        $totalAdmins = User::where('role', 'admin')->count();

        // New: Calculate changes for the month/week/today
        $booksAddedThisMonth = Book::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
        $usersAddedThisWeek = User::where('role', 'user')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $borrowsToday = Borrow::whereDate('borrow_date', Carbon::today())->count();

        // New: Get recent borrowing activities
        $recentActivities = Borrow::with(['user', 'book'])
                                  ->latest() // Order by latest created_at
                                  ->take(5) // Take last 5 activities
                                  ->get();

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalUsers',
            'totalAdmins',
            'availableBooks', // Can be used for other stats, or ignored if not in new design
            'totalBorrows',
            'booksAddedThisMonth',
            'usersAddedThisWeek',
            'borrowsToday',
            'recentActivities' // New data for recent activities
        ));
    }

    /**
     * Display a listing of books for Admin.
     */
    public function booksIndex()
    {
        $books = Book::all();
        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new book.
     */
    public function booksCreate()
    {
        return view('admin.books.create');
    }

    /**
     * Store a newly created book in storage.
     */
    public function booksStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'year' => 'required|integer|min:1000|max:' . (date('Y') + 1),
            'available' => 'required|integer|min:0',
        ]);

        Book::create($request->all());

        return redirect()->route('admin.books.index')->with('success', 'Book successfully added!');
    }

    /**
     * Show the form for editing the specified book.
     */
    public function booksEdit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    /**
     * Update the specified book in storage.
     */
    public function booksUpdate(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'year' => 'required|integer|min:1000|max:' . (date('Y') + 1),
            'available' => 'required|integer|min:0',
        ]);

        $book->update($request->all());

        return redirect()->route('admin.books.index')->with('success', 'Book successfully updated!');
    }

    /**
     * Remove the specified book from storage.
     */
    public function booksDestroy(Book $book)
    {
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Book successfully deleted!');
    }

    /**
     * Display the form for admin to record a book borrowing.
     */
    public function createBorrowForm()
    {
        $users = User::where('role', 'user')->get();
        $books = Book::where('available', '>', 0)->get();
        return view('admin.borrows.create_form', compact('users', 'books'));
    }

    /**
     * Store a newly recorded book borrowing by admin.
     */
    public function storeBorrow(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
        ]);

        $book = Book::find($request->book_id);

        if (!$book || $book->available <= 0) {
            return redirect()->back()->with('error', 'Book is not available for borrowing.');
        }

        $book->decrement('available');

        Borrow::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'borrow_date' => $request->borrow_date,
            'return_date' => null,
        ]);

        return redirect()->route('admin.borrows.index')->with('success', 'Book borrowing successfully recorded by admin!');
    }

    /**
     * Display the list of all borrowings for Admin.
     */
    public function borrowsIndex()
    {
        $borrows = Borrow::with(['user', 'book'])->get();
        return view('admin.borrows.index', compact('borrows'));
    }

    /**
     * Show the form for adding a new user (admin function).
     */
    public function usersCreate()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user (by admin) in storage.
     */
    public function usersStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:admin,user',
            'age' => 'nullable|integer|min:0',
            'phone_number' => 'nullable|string|max:20',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('user123'),
            'role' => $request->role,
            'age' => $request->age,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('admin.users.create')->with('success', 'User successfully added with password "user123". Please inform the user!');
    }

    /**
     * Display a listing of users for Admin.
     */
    public function usersIndex()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function usersEdit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function usersUpdate(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
            'age' => 'nullable|integer|min:0',
            'phone_number' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->except('password', 'password_confirmation');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User successfully updated!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function usersDestroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User successfully deleted!');
    }
}
