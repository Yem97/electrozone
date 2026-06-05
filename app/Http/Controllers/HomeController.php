<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Equipments;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        // examples:
        $this->middleware(['permission:access-dashboard'],["only" =>["index","show"]]);

    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
     
        // Equipments
        $totalEquipments = Equipments::count();
        $totalAvailable = Equipments::sum('available_quantity');

        // Users
        $totalUsers = User::count();

    
        // Category total
        $totalEquipmentCategories = Categories::count();

        return view('home', compact(
            'totalEquipments',
            'totalAvailable',
            'totalUsers',
            'totalEquipmentCategories' 
        ));
    }
}
