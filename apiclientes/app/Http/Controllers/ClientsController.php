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
use GuzzleHttp\Client;

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
        $doc_number = $this->validateDocNumber($client->doc_number) == true ? 1 : 0;
        $zip_code = $this->validateZipCode($client->zip_code) == true ? 1 : 0;

        if($doc_number == 1 && $zip_code == 1) {
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
        } else {
            return response()->json([
                'message' => 'Invalid document number or zip code'
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
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
        
        $doc_number = $this->validateDocNumber($client->doc_number) == true ? 1 : 0;
        $zip_code = $this->validateZipCode($client->zip_code) == true ? 1 : 0;

        if($doc_number == 1 && $zip_code == 1) {
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
    } else {
            return response()->json([
                'message' => 'Invalid document number or zip code'
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
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

    private function validateZipCode($zip_code)
    {
        $client = new Client();
        $response = $client->get("https://viacep.com.br/ws/{$zip_code}/json/");
        $data = json_decode($response->getBody(), true);
        if ($data['codigo'] <> 200) {
            return false;
        }

        return true;
    }

    private function validateDocNumber($doc_number)
    {
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
    
        if (strlen($cpf) != 11) {
            return false;
        }
    
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
    
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            
            $d = ((10 * $d) % 11) % 10;
            
            if ($cpf[$c] != $d) {            
                return false;
            }
    }
        return true;
    }
}
