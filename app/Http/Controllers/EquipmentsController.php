<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Equipments;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf ;

class EquipmentsController extends Controller
{
    public function __construct()
    {
        // examples:
        $this->middleware(['permission:equipment-list'],["only" =>["index","show"]]);
        $this->middleware(['permission:equipment-create'],["only" =>["create","store"]]);
        $this->middleware(['permission:equipment-edit'],["only" =>["edit","update"]]);
        $this->middleware(['permission:equipment-delete'],["only" =>["destroy"]]);

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Equipments::with('category');

        // Filter by category if provided
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Search by name
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $equipments = $query->get();
        $categories = Categories::all(); // Load all categories for filter dropdown

        return view('equipments.index', compact('equipments', 'categories'));
    }


    /**
     * Show the form for creating a new resource.
     */
     public function create()
    {
        // Fetch all categories to display in the dropdown
        $categories = Categories::all();

        // Return the create view with categories
        return view('equipments.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validate the input
    $request->validate([
        'name' => 'required|string|max:255|unique:equipments,name',
        'unit_price' => 'required|numeric|min:1',
        'partner_unit_price' => 'Required|numeric|min:1',
        'initial_quantity' => 'required|integer|min:1',
        'category_id' => 'required|exists:categories,id', // Validate the category_id
        'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:5120'
    ]);

    // Get the last numeric part
    $last = Equipments::orderBy('id', 'desc')->first();
    $number = $last ? intval(substr($last->unic_code, 8)) + 1 : 1;

    // Pad the number with leading zeros
    $formatted = str_pad($number, 7, '0', STR_PAD_LEFT); // '0000001', '0000002', etc.

    // Final code
    $unic_code = 'BSAEVENT' . $formatted;
    
    // Handle image upload if provided
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('equipments', 'public');
    }

    // Create the new equipment
    Equipments::create([
        'category_id' => $request->category_id, // Save category_id
        'name' => $request->name,
        'unit_price' => $request->unit_price,
        'initial_quantity' => $request->initial_quantity,
        'partner_unit_price' => $request->partner_unit_price,
        'available_quantity' => $request->initial_quantity, // same as initial
        'used_quantity' => 0,
        'returned_quantity' => 0,
        'unic_code' => $unic_code,
        'image' => $imagePath,
    ]);

    return redirect()->route('equipments.index')->with('success', 'Équipement créé avec succès.');
}



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $equipment = Equipments::find($id);

        return view("equipments.show", compact('equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
     public function edit(string $id)
    {
        $equipment = Equipments::find($id);
        $categories = Categories::all();  // Get all categories
        
        return view("equipments.edit", compact('equipment', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
    $equipment = Equipments::findOrFail($id);

    $validatedData = $request->validate([
        'name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('equipments')->ignore($equipment->id),
        ],
        'unit_price' => 'required|numeric|min:0',
        'partner_unit_price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:5120',
        'quantity_action' => 'nullable|in:add,replace',
        'add_quantity' => 'nullable|required_if:quantity_action,add|numeric|min:0',
        'new_quantity' => 'nullable|required_if:quantity_action,replace|numeric|min:0',
    ]);

    // Handle image upload
    $imagePath = $equipment->image;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('equipments', 'public');
    }

    // Initialize new quantity values
    $newInitialQuantity = $equipment->initial_quantity;
    $newAvailableQuantity = $equipment->available_quantity;

    // Update quantity based on action
    if ($validatedData['quantity_action'] === 'add') {
        $newInitialQuantity += $validatedData['add_quantity'];
        $newAvailableQuantity += $validatedData['add_quantity'];
    } elseif ($validatedData['quantity_action'] === 'replace') {
        $newInitialQuantity = $validatedData['new_quantity'];
        $newAvailableQuantity = $validatedData['new_quantity'];
    }

    // Update equipment
    $equipment->update([
        'name' => $validatedData['name'],
        'initial_quantity' => $newInitialQuantity,
        'available_quantity' => $newAvailableQuantity,
        'unit_price' => $validatedData['unit_price'],
        'partner_unit_price' => $validatedData['partner_unit_price'],
        'category_id' => $validatedData['category_id'],
        'image' => $imagePath,
    ]);

    return redirect()->route('equipments.index')->with('success', 'Équipement mis à jour avec succès.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $equipment = Equipments::find($id);
        $equipment->delete();
        return redirect()->route("equipments.index")->with("success","Equipment deleted.");

    }

    public function downloadCatalog()
    {
        $equipments = Equipments::with('category')->get(); // Load equipment with category if applicable

        $pdf = Pdf::loadView('equipments.catalog', compact('equipments'));

        return $pdf->download('catalogue_equipements.pdf');
    }
}
