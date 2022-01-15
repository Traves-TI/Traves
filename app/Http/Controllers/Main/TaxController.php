<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $taxes = (Tax::all())->sortBy('value');
        
        $tax = null;
        $tax = $request->all();
        
        if(!(is_null($tax)) and isset($tax["taxId"])){
            $tax = Tax::find($tax["taxId"]);
        }
        
        return view('admin.taxes.index', compact('taxes', 'tax'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tax = $request->except('_token');
        if(Tax::create($tax)){
            $request->session()->flash("success", "The tax was created");
            return redirect()->back();
        }
        return redirect()->back()->withErrors(["tax.created" => __("There was an error creating the tax")])->withInput($tax);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show(Tax $tax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit(Tax $tax)
    {   
        
        return redirect()->route('admin.tax.index', ["taxId" => $tax->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tax $tax)
    {
        $newTax = $request->except('_method', '_token');
        if($tax->update($newTax)){
            $request->session()->flash("success", __('The tax was updated with success'));
            return redirect()->back();
        }
        return redirect()->back()->withErrors(["tax.update.error" =>  __('It wasn\'t possible to update the tax')])->withInput($newTax);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tax $tax)
    {
        if($tax->delete()){
            session()->flash('success', 'The tax was deleted with success');
            return redirect()->route('admin.tax.index');
        }
        return redirect()->route('admin.tax.index')->withErrors(["client.delete" => "It wasn't possible to delete the tax"]);

    }
}
