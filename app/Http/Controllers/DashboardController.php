<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::count();
        $user = User::where('is_admin',0)->count();
        $admin = User::where('is_admin',1)->count();
        return view('admin.dashboard.index',compact('mahasiswa','user','admin'));

    }
    
    public function welcome()
    {
       return redirect('/dashboard');
    }
}
