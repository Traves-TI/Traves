<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyValidationRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
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
        $user = Auth::user();
        
        $companies = ($user->level == 0) ? Company::orderBy('name','ASC') : $user->companies();
      
        if(!empty($data)){
            if(isset($data["entries"]) and !empty($data["entries"])){
                $quant = $data["entries"];
            }
            
            if(isset($_GET["search"])){
                if(!empty($_GET["search"])){
                    $companies = $companies->where("name", 'like', '%' . $data["search"] . '%');
                }else{
                    return redirect()->route('admin.companies.index');
                }

            }
        }

        if(isset($_GET["entries"]) and isset($_GET["page"]) and $_GET["entries"] > $companies->count()){
            return redirect()->route('admin.companies.index', $request->except("page"));
        }

    
        $companies = $companies->count() ? $companies->paginate($quant) : $companies;
        return view('admin.companies.index', [
            'companies' => $companies,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyValidationRequest $request)
    {

        /*for($i=0;$i<=100;$i++){
            DB::statement("DROP DATABASE IF EXISTS traves_{$i}");
        }
        dd('LOrem');
        */
        $data = $request->except('_token');

        $user = Auth::user();
        $company = Company::create($data, $user);
        
        if($company){
            $request->session()->flash('success', 'The company was created with success');
            return redirect()->route('admin.companies.index');
        } else {
           
            $errors['company.create'] = __('It wasn\'t possible to create a company');
        }

        return redirect()->back()->withErrors($errors)->withInput($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        dd('Guardar em uma sessão global o ID da sessão e redirecionar para o index dos clientes');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view("admin.companies.edit", ["company" => $company]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyValidationRequest $request, Company $company)
    {
        $data = $request->except('_token');
        $erros = [];
        if($company){
            $res = $company->update($data);
            if($res){
                $request->session()->flash('success', 'The client was updated with success');
                // TODO Encaminhar utilizador para os produtos 
                return redirect()->route('admin.companies.edit', [$company]);
            }
            $erros['company.update'] = __("There was an error updating company details");
        }else{
           $errors[] =  __('It wasn\'t possible to update the company');
        }

        return redirect()->back()->withErrors($errors)->withInput($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $nameCompany = $company->name;
        $errors = [];
        if($company->delete()){
            session()->flash("success", __("The company: $nameCompany was deleted with success"));
        }else{
            $errors['companies.delete'] = __("It wasn\'t possible to delete the company: $nameCompany'");
        }
        return redirect()->back()->withErrors($errors);
    }
}
