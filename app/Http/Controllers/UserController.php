<?php

namespace App\Http\Controllers;

use App\Models\User;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(){
        abort_if(Gate::denies('user_management_access'),
        Response::HTTP_FORBIDDEN, '403 Forbidden');
    }
    public function index()
    {
        $users =  User::all() ;
        return inertia('users/Index' , [
            'users' => $users->load('roles'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('users/Create');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success' , 'User Deleted !');
    }
}
