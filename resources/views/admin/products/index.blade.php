
@extends('admin.app')

@section('content') 

@include('admin.parts.alerts')

<div class="table-responsive">

    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <div class="card">
            <div class="card-body">

           
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div id="dataTable_length">
                            <label>{{__('Items per page')}}  
                                <select name="dataTable_length" class="custom-select custom-select-sm form-control form-control-sm display-inline-block">
                                    <?
                                        $entries = [20, 50, 100];
                                        foreach ($entries as $value) {
                                            $op = ((isset($_GET["entries"]) and in_array($_GET["entries"], $entries)) and $value == $_GET["entries"]) ? "selected" : "";
                                            echo "<option value='{$value}' $op>$value</option>";
                                        }
                                    ?>
                                    
                                </select></label>
                        </div>
                    </div>
                <div class="col-sm-12 col-md-6">
                    <form action="" method="get" name="searchForm">
                        <label class="nowrap">{{ __('Search:') }}
                            <input type="search" class="display-inline-block form-control form-control-sm" placeholder="{{ __('Keywords') }}" value='@isset($_GET["search"]){{ $_GET["search"] }}@endisset' name='search'>
                            <button class="btn btn-sm btn-info display-inline-block">{{__('Send')}}</button>
                        </label>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <hr>
@if(isset($products) AND $products->count() > 0)
   
        <div class="card">
            <div class="card-body">   
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" style="width: 100%;">
                        
                            <thead>
                                <tr role="row">
                                    <th tabindex="0" rowspan="1"git >{{ __('Reference') }}</th>
                                    <th tabindex="0" rowspan="1" colspan="1">{{ __('Name') }}</th>
                                    <th tabindex="0" rowspan="1" colspan="1">{{ __('Price') }}</th>
                                    <th tabindex="0" rowspan="1" colspan="1">{{ __('Quantity') }}</th>
                                    <th tabindex="0" rowspan="1" colspan="1">{{ __('Tax') }}</th>
                                    <th tabindex="0" rowspan="1" class="text-center" colspan="1"> {{ __('Operations') }} </th>
                                </tr>
                            </thead>

                            <tbody>
                            
                                
                            @foreach($products as $product)
                                
                                <tr class="odd">
                                    <td>{{ $product->reference }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>@if(isset($product->price) AND !is_null($product->price)){{ $product->price }} € @else 0.00 € @endif</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->tax }}</td>
                                    <td class="text-center">
                                            <a class='btn btn-sm btn-info display-inline-block' href=" {{ route('admin.products.edit', [$product]) }} " ><i class="fa fa-edit"></i></a> 
                                            <form data-title='{{__("Delete Product")}}' data-callback='oi' data-btn-cancel='{{__("Cancel")}}' data-btn-save='{{__("Continue")}}' data-class='error-modal' data-confirm='{{__("Are you sure that delete this product? ") . $product->name}}'  class='display-inline-block' method="POST" action="{{ route('admin.products.destroy', $product->id) }}"> @csrf @method('DELETE') <button class="btn-sm btn btn-danger"><i class='fa fa-trash'></i></button></form>
                                    </td>
                                </tr>
                            @endforeach
                                
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>

    <br />
        {{ $products->appends(request()->query())->links() }}
    </div>
    </div>

    @else
    <div class="card">
        <div class="card-body">
            <p>{{__('There are no products to be shown.')}}</p>

        </div>
    </div>
    
    @endif

@endsection