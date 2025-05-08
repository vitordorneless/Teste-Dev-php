<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->query('q');
        if ($query) {
            $clients = Clients::where('full_name', 'LIKE', "%$query%")
                ->orWhere('doc_number', 'LIKE', "%$query%")
                ->orWhere('zip_code', 'LIKE', "%$query%")
                ->get()
                ->paginate(10);
        } else {
            $clients = Clients::all()->paginate(10);
        }

        return response()->json([
            'data' => $clients
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'doc_number' => 'required|string|max:255|unique:clients',
            'email' => 'required|string|email|max:255|unique:clients',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:10'
        ]);
        
        $client = Clients::create($data);
        
        return response()->json([
            'message' => 'Client created successfully',
            'data' => $client
        ], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'data' => Clients::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->json([
            'data' => Clients::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Clients::findOrFail($id);
        
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'doc_number' => 'required|string|max:255|unique:clients,doc_number,' . $client->id,
            'email' => 'required|string|email|max:255|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:10'
        ]);
        
        $client->update($data);
        
        return response()->json([
            'message' => 'Client updated successfully',
            'data' => $client
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Clients::findOrFail($id);
        $client->delete();
        return response()->json([
            'message' => 'Client deleted successfully'
        ], JsonResponse::HTTP_NO_CONTENT);
    }
}
