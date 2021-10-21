<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientValidationRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = $request->all();
        $quant = 20;
        $clients = Client::orderBy('name','ASC');
        if(!empty($data)){
            if(isset($data["entries"]) and !empty($data["entries"])){
                $quant = $data["entries"];
            }
            
            if(isset($_GET["search"])){
                if(!empty($_GET["search"])){
                    $clients = $clients->where("name", 'like', '%' . $data["search"] . '%');
                }else{
                    return redirect()->route('admin.clients.index');
                }

            }
        }

        if(isset($_GET["entries"]) and isset($_GET["page"]) and $_GET["entries"] > $clients->count()){
            return redirect()->route('admin.clients.index', $request->except("page"));
        }


        
        $clients = $clients->paginate($quant);
        return view('admin.clients.index', [
            'clients' => $clients,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientValidationRequest $request)
    {

        $data = $request->except('_token');

        $client = Client::create($data);

        $errors = [];
        if($client){
            $request->session()->flash('success', 'The client was created with success');
            return redirect()->route('admin.clients.index');
        } else {
           
            $errors['client.create'] = __('It wasn\'t possible to create a client');
        }

        return redirect()->back()->withErrors($errors)->withInput($data);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view("admin.clients.edit", ["client" => $client]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(ClientValidationRequest $request, Client $client)
    {
        $data = $request->except('_token');
        $erros = [];
        if($client){
            $res = $client->update($data);
            if($res){
                $request->session()->flash('success', 'The client was updated with success');
                return redirect()->route('admin.clients.edit', [$client]);
            }
            $erros['client.update'] = __("There was an error updating client details");
        }else{
           $errors[] =  __('It wasn\'t possible to update the client');
        }

        return redirect()->back()->withErrors($errors)->withInput($data);

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        if($client->delete()){
            session()->flash('success', 'The client was deleted with success');
            return redirect()->route('admin.clients.index');
        }
        return redirect()->route('admin.clients.index')->withErrors(["client.delete" => "It wasn't possible to delete the cliente"]);

    }
}
