<div class="card mb-100">
    <div class="card-body">

        <h3>
            @isset($product)
                {{ __('Edit product') }}
            @else
                {{ __('New product') }}
            @endisset
        </h3>

        <hr >

        <form 
            method="POST" 
            action="@isset($product) {{ route('admin.products.update', ['product' => $product]) }}@else {{  route('admin.products.store') }} @endisset" 
            class="product-form"
            enctype="multipart/form-data">
            
            @isset($product)
                @method('PUT')
            @endisset

            @csrf()
            @include('admin.parts.alerts')

                <div class='row form-group'>
                    
                    <div class='col-md-12 col-sm-12'>
                        <input type='text' 
                            name='name' 
                            value='@isset($product){{ $product->name }}@else{{ old('name') }}@endisset'
                            placeholder="{{ __('Name') }}" 
                            class='form-control' 
                            required
                            />
                    </div>
                </div>
                <div class='row form-group'>

                    <div class='col-md-4 col-sm-12'>
                        <input type='text' 
                            name='description' 
                            value='@isset($product){{ $product->description }}@else{{ old('description')}}@endisset'
                            placeholder="{{ __('Description') }}" 
                            class='form-control mask-description' 
                            />
                    </div>
                    
                    <div class='col col-md-4 col-sm-12'>
                        <input type='number' 
                            min='0'
                            name='quantity' 
                            value='@isset($product){{ $product->quantity }}@else{{ old('quantity', 1)}}@endisset'
                            placeholder="{{ __('Quantity') }}" 
                            class='form-control' 
                            />
                    </div>
                    
                    <div class='col col-md-4 col-sm-12'>
                        <input type='text' 
                            name='reference' 
                            value='@isset($product){{ $product->reference }}@else{{ old('reference')}}@endisset'
                            placeholder="{{ __('Reference') }}" 
                            class='form-control' 
                            />
                    </div>

                </div>

              <div class="row form-group">
                    <div class='col-md-4 col-sm-12'>
                        <select name='tax_id' 
                                class='form-control'
                                required>
                            <option disabled>Choose a tax</option>
                            @if (isset($taxes))
                                @foreach ($taxes as $tax)
                                    <option value='{{ $tax->id }}' @if(isset($product) and @$tax->id == $product->tax_id) selected @endif >{{ $tax->value . "% - " . $tax->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    <div class='col-md-4 col-sm-12'>      
                        <select name='status_id' 
                        class='form-control'
                        required>
                            <option disabled>Choose a status</option>
                            @if (isset($status))
                                @foreach ($status as $s)
                                    <option value='{{ $s->id }}' @if(isset($product) and @$s->id == $product->status_id) selected @endif >{{ $s->name }}</option>
                                @endforeach
                            @endif
                        </select> 
                    </div>
                    <div class='col-md-4 col-sm-12'>  
                        <select name='product_type_id' 
                        class='form-control'>
                            <option value=''>{{__('Normal')}}</option>
                            @if (isset($product_type))
                                @foreach ($product_type as $pt)
                                    <option value='{{ $pt->id }}' @if(isset($product) and @$pt->id == $product->product_type_id) selected @endif>{{ $pt->name }}</option>

                                @endforeach
                            @endif
                        </select> 
                    </div>

                </div>
                

                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="custom-file">
                            <input type="file" name='cover' class="custom-file-input" id="cover">
                            
                            <label class="custom-file-label" for="cover">@if(isset($product) and $product->cover) {{ $nameImgCover }} @else {{__("Choose cover image")}} @endif</label>
                            <small><span class="text-danger">*{{__("Types: jpg, jpeg, gif, png | Max size: 2MB") }}</small></span>
                            <p><img class='previewImage img-thumbnail mt-10 mb-10 maxHeight150' width='120' @if(isset($product) and $product->cover) src='{{asset($product->cover)}}' @else hidden @endif></p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name='image' id="image">
                            <label class="custom-file-label" for="image">@if(isset($product) and $product->image) {{ $nameImgMain }} @else {{__("Choose cover image")}} @endif</label>
                            <small><span class="text-danger">*{{__("Types file: jpg, jpeg, gif, png | Max size: 2MB") }}</small></span>
                            <p><img  class='previewImage img-thumbnail mt-10 mb-10 maxHeight150' width='120' @if(isset($product) and $product->image) src='{{asset($product->image)}}' @else hidden @endif></p>
                    </div>
                </div>
            </div>

            <div class='row text-right  ' >
                <div class='col-md-12'>
                    <button class='btn btn-success'>
                        @isset($product)
                        {{ __('Save') }}
                    @else
                        {{ __ ('Submit') }}
                        @endisset

                    </button>
                </div>
            </div>


        </form>
    </div>
</div>


    <script>

        let clicked=false;
        let $file = $("input[type='file']");
        
        function validator($file) {
            
            if($file == null) return false;
            // Temos o file
            $fileSize = Math.ceil($file.size / 1024 / 1024);

        
            if($fileSize > 2){
                URL.revokeObjectURL($file);
                alert("é graaaandeeee");
                return false;
            }
            
            return true;
        }
        
        /*
        $file.on("click", function(e){
            if(clicked){
                validator(e.target.files[0]);
                clicked = false;
            }
                clicked = true;

            
        });*/

        $file.on("click", function(e){
        
            if(!clicked){
                $file.on("change", function(e){
                    $fileUploaded = e.target.files[0];
                    $("input[name='cover']").val("");
                    
                    if(validator($fileUploaded)){                        

                        $fileURL = URL.createObjectURL($fileUploaded);
                        $label = $(this).next("label");
                        $imageName = $fileUploaded.name;
                        $label.text($imageName);
                        $(this).parent().find(".previewImage").removeAttr("hidden").attr("src",$fileURL);
                    } 
                });
        }
            clicked = true;
          
});  

    </script>
    
