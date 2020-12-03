<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the view courses.
     */
    public function courses()
    {
        return view('courses');
    }

    /**
     * Show the view manage courses.
     */
    public function manageCourses()
    {
        return view('manage.manage-courses');
    }

    /**
     * Show the view manage categories.
     */
    public function manageCategories()
    {
        return view('manage.manage-categories');
    }

    /**
     * Show the view manage users.
     */
    public function manageUsers()
    {
        $users = User::all();
        return view('manage.manage-users', compact('users'));
    }
    
}
