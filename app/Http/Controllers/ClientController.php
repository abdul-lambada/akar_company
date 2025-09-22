<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::orderByDesc('client_id')->paginate(10);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:clients,email',
            'whatsapp' => 'nullable|string|max:30',
            'address' => 'nullable|string',
        ]);

        Client::create($data);
        return redirect()->route('clients.index')->with('success', 'Client created');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'client_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:clients,email,'.$client->client_id.',client_id',
            'whatsapp' => 'nullable|string|max:30',
            'address' => 'nullable|string',
        ]);

        $client->update($data);
        return redirect()->route('clients.index')->with('success', 'Client updated');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client deleted');
    }

    public function show(Client $client)
    {
        $client->load('invoices');
        return view('clients.show', compact('client'));
    }
}