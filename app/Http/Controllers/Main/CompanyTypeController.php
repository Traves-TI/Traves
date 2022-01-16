<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\CompanyType;
use Illuminate\Http\Request;

class CompanyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companyType = (CompanyType::all())->sortBy('value');
        
        $companyTypeRequest = null;
        $companyTypeRequest = $request->all();
        
        /* Instalação, configuração e inserção de produtos */
        if(!(is_null($companyTypeRequest)) and isset($companyTypeRequest["companyType"])){
            $companyTypeRequest = CompanyType::find($companyTypeRequest["companyType"]);
            
        }
       
        
        return view('admin.types_company.index', compact('companyType', 'companyTypeRequest'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $companyType = $request->except('_token');
        if(CompanyType::create($companyType)){
            $request->session()->flash("success", "The company type was created");
            return redirect()->back();
        }
        return redirect()->back()->withErrors(["company-type.created" => __("There was an error creating the company type")])->withInput($companyType);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompanyType  $companyType
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyType $companyType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanyType  $companyType
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyType $companyType)
    {
        return redirect()->route('admin.company-type.index', ["companyType" => $companyType->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CompanyType  $companyType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompanyType $companyType)
    {
        
        $newCompanyType = $request->except('_method', '_token');
        if($companyType->update($newCompanyType)){
            $request->session()->flash("success", __('The company type was updated with success'));
            return redirect()->back();
        }
        return redirect()->back()->withErrors(["company-type.update.error" =>  __('It wasn\'t possible to update the company type')])->withInput($newCompanyType);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanyType  $companyType
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyType $companyType)
    {
        if($companyType->delete()){
            session()->flash('success', 'The company type was deleted with success');
            return redirect()->route('admin.company-type.index');
        }
        return redirect()->route('admin.company-type.index')->withErrors(["company-type.delete" => "It wasn't possible to delete the company type"]);

    
    }
}
