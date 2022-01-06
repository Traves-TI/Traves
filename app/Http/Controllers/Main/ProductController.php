<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Status;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ProductController extends Controller
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
        $products = Product::orderBy('name','ASC');


        if(!empty($data)){
            if(isset($data["entries"]) and !empty($data["entries"])){
                $quant = $data["entries"];
            }
            
            //TODO we have to make this search a bit more useful :D
            if(isset($_GET["search"])){
                if(!empty($_GET["search"])){
                    $products = $products->where("name", 'like', '%' . $data["search"] . '%');
                }else{
                    return redirect()->route('admin.products.index');
                }

            }
        }

        if(isset($_GET["entries"]) and isset($_GET["page"]) and $_GET["entries"] > $products->count()){
            return redirect()->route('admin.clients.index', $request->except("page"));
        }

        $products = $products->paginate($quant);

        //TODO show the thumbnails in the view :P
        return view('admin.products.index', [
            'products' => $products,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $taxes = Tax::all()?:null;
        $product_type = ProductType::all()?:null;
        $status = Status::all()?:null;
        
        return view("admin.products.create", ['taxes' => $taxes, 'product_type' => $product_type, 'status' =>  $status]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        
        if(!isset($data['slug']) AND isset($data['name'])){
            $data['slug'] = Product::getSlug($data["name"]);
        }

        //TODO We have to store the images URL in the database if it was uploaded :D
        $errors = [];
        if($data['slug']){
            $product = Product::create($data);
            if($product){
                $request->session()->flash('success', 'The product was created with success');
                return redirect()->route('admin.products.index');
            } else {
            
                $errors['product.create'] = __('It wasn\'t possible to create a product');
            }
        }else{
            $errors['product.slugAlreadyExists'] = __('It wasn\'t possible to create a product, there a product with the same name');
        }
    
        return redirect()->back()->withErrors($errors)->withInput($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $taxes = Tax::all()?:null;
        $product_type = ProductType::all()?:null;
        $status = Status::all()?:null;
        
        $product = Product::find($product)->first();
       
        return view("admin.products.edit", [
            "product" => $product, 
            "taxes" => $taxes, 
            "product_type" => $product_type,
            "status" => $status
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $newProduct = $request->all();
        
        if(!empty($newProduct)){
            $newProduct = $request->except("_method", "_token");
            
            if($product and $product->update($newProduct)){
                $request->session()->flash('success', 'The product was edited with success');
                return redirect()->back()->withInput($newProduct);
            }

         } else {
           
            $errors['product.edit'] = __('It wasn\'t possible to edit a product');
        }

        return redirect()->back()->withErrors($errors)->withInput($newProduct);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
