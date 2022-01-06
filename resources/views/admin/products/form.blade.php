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
                            _required
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
      
                        <select name='Tax_id' 
                                class='form-control'
                                required>
                            <option disabled>Choose a tax</option>
                       
                            @if (isset($taxes))
                                @foreach ($taxes as $tax)
                                    <option value='{{ $tax->id }}'>{{ $tax->value . "% - " . $tax->name }}</option>
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
                                    <option value='{{ $s->id }}'>{{ $s->name }}</option>
                                @endforeach
                            @endif
                        </select> 
                    </div>
                    <div class='col-md-4 col-sm-12'>       
                        <select name='product_type' 
                        class='form-control'>
                            <option value=''>{{__('Normal')}}</option>
                            @if (isset($product_type))
                                @foreach ($product_type as $pt)
                                    <option value='{{ $pt->id }}'>{{ $pt->name }}</option>
                                @endforeach
                            @endif
                        </select> 
                    </div>

                </div>

                
                <div class="row form-group">
                    <div class="col-md-6">
                        <input class='form-control' type="file" name='cover' src="" alt="">
                    </div>
                    <div class="col-md-6">
                        <input class='form-control' type="file" name='image' src="" alt="">
                    </div>
                </div>

            <div class='row form-group'>
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