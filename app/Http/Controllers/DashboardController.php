<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUser = User::count();
        $totlProduct = product::count();
        return view('dashboard.index', compact('totalUser','totlProduct'));
    }
}
