<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Client;
use App\Models\ClientLocation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'page' => 'nullable|numeric|min:1',
                'keyword' => 'nullable|string|max:255',
                'client_active' => 'nullable|numeric|max:5',
            ]);
            
            $list = Client::with('location')->select(
                'id',
                'client_name',
                'company_name',
                'contact_number',
                'email',
                'client_contact_name',
                'client_active',
                'notes',
            );
            
            if(!empty($data['keyword'])) {
                $keyword = $data['keyword'];
                $list->where(function ($query) use ($keyword) {
                    $query->where('client_name', 'like', "%$keyword%")
                        ->orWhere('company_name', 'like', "%$keyword%")
                        ->orWhere('email', 'like', "%$keyword%");
                });
                
            }
            if ($request->filled('client_active')) {
                $list->where('client_active', $request->client_active);
            }
            $clients = $list->orderBy('created_at', 'desc')->paginate(4);
            
            return view('clients.clients', compact('clients'));
        } catch (\Exception $e) {
            Log::error('Error in: ' . __METHOD__, [
                'message' => $e->getMessage(),
                'Line' => $e->getLine(),
                'File' => $e->getFile()
            ]);
            return response()->json(['error' => 'Failed to fetch clients'], 400);
        }
    }

    public function create()
    {
        return view('clients.client_create');
    }

    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $data=$request->all();

            $validator = Validator::make($data, [
                'client_name' => 'required|string|max:255',
                'contact_number' => 'required|string|max:255|regex:/^\+?[0-9\s\-\(\)]+$/',
                'notes' => 'nullable|string|max:255',
                'email' => 'required|email|max:255|regex:/^[\w\.-]+@[\w\.-]+\.\w{2,4}$/',
                'company_name' => 'required|string|max:255|',
                'client_contact_name' => 'required|string|max:255',
                'client_active' => 'required|string|max:20',
                'client_HQ' => 'required|string|max:255',
                'client_billing' => 'required|string|max:255',
                'client_country' => 'required|string|max:255',
                'client_city' => 'required|string|max:100',
                'client_state_province' => 'required|string|max:255',
                'client_zipcode' => 'required|string|max:20',
                // 'userId' => 'required',
            ]);

            $userId = 2;
            $data['userId'] = $userId;
            
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
    

            $data['client_active'] = ($request->client_active == 'on') ? 1 : 0;

            
            $client = new Client();
            $client->client_name = $data['client_name'];
            $client->company_name = $data['company_name'];
            $client->contact_number = $data['contact_number'];
            $client->email = $data['email'];
            $client->client_contact_name = $data['client_contact_name'];
            $client->client_active = $data['client_active'];;
            $client->notes = $data['notes'];
            $client->userId = $data['userId'];
            $client->project_id = $data['project_id'] ?? null; 
            $client->save();
            DB::commit();
            
            $clientId = $client->id;
            if(!$clientId){
                DB::rollBack();
                return redirect()->back()->with('error', 'Failed to create client location.')->withInput();
            }
            $data['client_id'] = $clientId;
            
            $clientLocation = new ClientLocation();
            $clientLocation->client_HQ = $data['client_HQ'];
            $clientLocation->client_billing = $data['client_billing'];
            $clientLocation->client_country = $data['client_country'];
            $clientLocation->client_city = $data['client_city'];
            $clientLocation->client_state_province = $data['client_state_province'];
            $clientLocation->client_zipcode = $data['client_zipcode'];
            $clientLocation->client_id = $data['client_id'];
            $clientLocation->save();
            DB::commit();
            return redirect()->route('clients.screen')->with('success', 'Client created successfully.');
        } catch (\Exception $e) {
            Log::error('Error in: ' . __METHOD__, [
                'message' => $e->getMessage(),
                'Line' => $e->getLine(),
                'File' => $e->getFile()
            ]);
        }
    }

    public function search(Request $request){
        $request->validate([
            'keyword' => 'required|string|max:255',
        ]);

        $clients = Client::where('client_name', 'like', '%' . $request->keyword . '%')
            ->limit(10)
            ->get(['id', 'client_name']);
        return response()->json($clients);
    }

    public function exportCLientList(Request $request){
        $data = $request->all();

            $validator = Validator::make($data, [
                'page' => 'nullable|numeric|min:1',
                'keyword' => 'nullable|string|max:255',
                'client_active' => 'nullable|numeric|max:5',
            ]);
            
            $list = Client::with('location')->select(
                'id',
                'client_name',
                'company_name',
                'contact_number',
                'email',
                'client_contact_name',
                'client_active',
                'notes',
            );
            
            if(!empty($data['keyword'])) {
                $keyword = $data['keyword'];
                $list->where(function ($query) use ($keyword) {
                    $query->where('client_name', 'like', "%$keyword%")
                        ->orWhere('company_name', 'like', "%$keyword%")
                        ->orWhere('email', 'like', "%$keyword%");
                });
                
            }
            if ($request->filled('client_active')) {
                $list->where('client_active', $request->client_active);
            }
        $clients = $list->orderBy('id', 'desc')->get();

        $fileName = 'clients_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($clients) {
            $handle = fopen('php://output', 'w');
            
            fwrite($handle, "\xEF\xBB\xBF");
            // Header CSV
            fputcsv($handle, [
                'ID',
                'Client Name',
                'Company',
                'Contact Name',
                'Email',
                'Phone',
                'Client Billing',
                'City',
                'State',
                'Status',
                'Notes',
            ]);

            foreach ($clients as $client) {
                fputcsv($handle, [
                    $client->id,
                    $client->client_name,
                    $client->company_name,
                    $client->client_contact_name,
                    $client->email,
                    '="' . $client->contact_number . '"',
                    $client->location->client_billing ?? 'none',
                    $client->location->client_city ?? 'none',
                    $client->location->client_state_province ?? 'none',
                    $client->client_active == 1 ? 'Active' : 'Inactive',
                    $client->notes,
                ]);
            }

            fclose($handle);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function getById(Client $client){
        try{
            // sua dung Route Model Binding thi khoi find or fail
            // $client = Client::with('location')->findOrFail($id);
            $client->load('location');
            return view('clients.client_update', compact('client'));
        } catch(\Exception $e){
            Log::error('get client detail failed', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);
            return redirect()
                ->back()
                ->with('error', 'get client detail failed.');
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $client = Client::with('location')->findOrFail($id);
            DB::beginTransaction();
            $data=$request->all();

            $validator = Validator::make($data, [
                'client_name' => 'required|string|max:255',
                'contact_number' => 'required|string|max:255|regex:/^\+?[0-9\s\-\(\)]+$/',
                'notes' => 'nullable|string|max:255',
                'email' => 'required|email|max:255|regex:/^[\w\.-]+@[\w\.-]+\.\w{2,4}$/',
                'company_name' => 'required|string|max:255|',
                'client_contact_name' => 'required|string|max:255',
                'client_active' => 'required|string|max:20',
                'client_HQ' => 'required|string|max:255',
                'client_billing' => 'required|string|max:255',
                'client_country' => 'required|string|max:255',
                'client_city' => 'required|string|max:100',
                'client_state_province' => 'required|string|max:255',
                'client_zipcode' => 'required|string|max:20',
                // 'userId' => 'required',
            ]);

            $userId = 2;
            $data['userId'] = $userId;
            
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $client->update([
                'client_name' => $data['client_name'],
                'company_name' => $data['company_name'],
                'client_contact_name' => $data['client_contact_name'],
                'email' => $data['email'],
                'contact_number' => $data['contact_number'],
                'notes' => $data['notes'] ?? null,
                'client_active' => $request->has('client_active') ? 1 : 0,
                'userId' => $userId,
            ]);

            $client->location()->updateOrCreate(
                ['client_id' => $client->id],
                [
                    'client_HQ' => $data['client_HQ'],
                    'client_billing' => $data['client_billing'],
                    'client_country' => $data['client_country'],
                    'client_city' => $data['client_city'],
                    'client_state_province' => $data['client_state_province'],
                    'client_zipcode' => $data['client_zipcode'],
                ]
            );

            DB::commit();

            return redirect()
                ->route('clients.screen')
                ->with('success', 'Client updated successfully');
                
        } catch(\Exception $e){
            dd($e);
            DB::rollBack();
            Log::error('Update client failed', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Update client failed.');
        }
    }
    
    public function delete($id)
    {
        try {
            $client = Client::with('location')->findOrFail($id);

            $client->delete();

            if ($client->location) {
                $client->location->delete();
            }

            return redirect()
                ->route('clients.screen')
                ->with('success', 'Client deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Delete client failed', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Delete client failed.');
        }
    }
} 