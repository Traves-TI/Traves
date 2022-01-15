<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Traits\HelperTrait;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Status;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;


class ProductController extends Controller
{
    Use HelperTrait;
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
                    return redirect()->route('admin.product.index');
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
        $errors = [];
        $data = $request->except('_token');
        $company_id = "";
        if(!is_null(Cookie::get('company'))) $company_id = Cookie::get('company');
        
        if(!isset($data['slug']) AND isset($data['name'])){
            $SLUG = Product::getSlug($data["name"]);
            if($SLUG){
                if(is_object($SLUG)){
                    $errors["product.excluded"] = __("Already exist a product with the same name");
                    $idProductExcluded = $SLUG->id;
                    return redirect()->back()->withErrors($errors)->withInput($data)->with(compact("idProductExcluded"));
                }
                
            }else{
                $errors['product.slugAlreadyExists'] = __('It wasn\'t possible to create a product, there a product with the same name');
            }
            $data['slug'] = $SLUG;
            /* Check if the product is deleted */
        }
       
        if(empty($errors)){
            
            if($data['slug']){
                // If have any file
                if(count($request->files)){
                    $pathImage = "";
                    foreach ($request->files as $key => $value) {
                        $pathImage = Product::storeImg($request->file($key), $company_id);
                        
                        if(!is_array($pathImage)){
                            $data[$key] = "images/" . $pathImage;
                        }else{
                            array_push($errors, $pathImage);
                        }
                    }
                    
                }
                $product = Product::create($data);
                if($product){
                    $request->session()->flash('success', 'The product was created with success');
                    return redirect()->route('admin.product.index');
                } else {
                
                    $errors['product.create'] = __('It wasn\'t possible to create a product');
                }
            }
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
       // dd($product->type()->first());
        $nameImgCover = $nameImgMain = "";
    
        $nameImgCover = (!is_null($product->cover)) ? explode('/', $product->cover) : null;
        $nameImgMain = (!is_null($product->image)) ? explode('/', $product->image) : null;
        
        $nameImgCover = (!is_null($nameImgCover)) ? $nameImgCover[count($nameImgCover) - 1]:null;
        $nameImgMain = (!is_null($nameImgMain)) ? $nameImgMain[count($nameImgMain) - 1]:null;
         
        return view("admin.products.edit", [
            "product" => $product, 
            "taxes" => $taxes, 
            "product_type" => $product_type,
            "status" => $status,
            "nameImgCover" => $nameImgCover,
            "nameImgMain" => $nameImgMain,
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
        $errors = [];
        $COVER = $request->input("hasCover")?:null;
        $IMAGE = $request->input("hasImage")?:null;

        $newProduct = $request->except(["_method", "_token", "hasCover", "hasImage"]);
        // Altera o slug
        if(!isset($newProduct['slug']) AND isset($newProduct['name'])){
            $SLUG = Product::getSlug($request["name"]);
            if($SLUG){
                if(is_object($SLUG)){
                    $errors["product.excluded"] = __("Already exist a product with the same name");
                    $idProductExcluded = $SLUG->id;
                    return redirect()->back()->withErrors($errors)->withInput($newProduct)->with(compact("idProductExcluded"));
                }
                
            }else{
                $errors['product.slugAlreadyExists'] = __('It wasn\'t possible to create a product, there a product with the same name');
            }

            $newProduct['slug'] = $SLUG;
        }
     
        if(empty($errors)){
            if($newProduct["slug"]){
                $company_id = "";
                if(!is_null(Cookie::get('company'))) $company_id = Cookie::get('company');
                
                // If have any file
                if(count($request->files)){
                    $pathImage = "/companies/$company_id/products/$product->id";
        
                    foreach ($request->files as $key => $value) {
                        
                        if(!is_null($key)){
                             $pathImage = Product::storeImg($request->file($key), $pathImage);
                            if(!is_array($pathImage)){
                                $newProduct[$key] = $pathImage;
                            }else{
                                array_push($errors, $pathImage);
                            }
                        }
                    }   
                }else{ 
                    if(is_null($COVER) and !(is_null($product->cover))){
                        if(HelperTrait::deleteImageStorage($product->cover)){
                            $newProduct["cover"] = $COVER; // NULLO 
                        }
                    }
                    if(is_null($IMAGE) and !(is_null($product->image))){
                        if(HelperTrait::deleteImageStorage($product->image)){
                            $newProduct["image"] = $IMAGE; // NULLO 
                        }
                    }
                }
        
           
            if(!empty($newProduct)){
                if($product and $product->update($newProduct)){
                    $request->session()->flash('success', 'The product was edited with success');
                    return redirect()->back()->withInput($newProduct);
                }
            } else {
                $errors['product.edit'] = __('It wasn\'t possible to edit a product');
            }
        }
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
        $nameProduct = $product->name;
       if($product->delete()){
            session(['success' => __("The product: $nameProduct was deleted")]);
            return redirect()->back();
       }

       return redirect()->back()->withErrors(["product.delete", __("There was an error deleting the product")]);
      
    }

    
    public function recoverProduct($id){
        if(is_null($id)) return view("admin.products.index");

        $product = Product::withTrashed()->find($id);
        if(!(is_null($product))){
            $product->deleted_at = null;
            if($product->save()){
                return redirect()->route('admin.product.edit', $product->id);
            }
            
        }
    }
}
