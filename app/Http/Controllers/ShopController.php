<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Equipments;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipments::query();

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->has('q') && $request->q != '') {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $equipment = $query->paginate(12);
        $categories = Categories::all();

        // Fetch featured items from category ID 1 (change as needed)
        $featuredItems = Equipments::where('category_id', 1)->latest()->take(10)->get();

        return view('shop.index', compact('equipment', 'categories', 'featuredItems'));
    }
}