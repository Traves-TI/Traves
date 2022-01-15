<?
    $SHOW_SIDEBAR = false;
?>
@extends('admin.app')
  
@section('content') 

@include('admin.parts.alerts')

<div class="table-responsive">
    
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <!-- TODO - o tax esta na mesma pagina por enquanto que o dashboard não esta pronto -->
        @include('admin.taxes.create')
        @if(isset($taxes) AND $taxes->count() > 0)
                
                <div class="card">
                    <div class="card-body">   
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" style="width: 100%;">
                                    <thead>
                                        <tr role="row">
                                            <th tabindex="0" rowspan="1" colspan="1" >{{ __('Name') }}</th>
                                            <th tabindex="0" rowspan="1" colspan="1">{{ __('Value') }}</th>
                                            <th tabindex="0" rowspan="1" class="text-center" colspan="1"> {{ __('Operations') }} </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($taxes as $t)
                                        
                                        <tr class="odd">
                                            <td >{{ $t->name }}</td>
                                            <td>{{ $t->value }}</td>
                                            
                                            <td class="text-center">
                                                <a title='{{ __('Edit tax') }}' class='btn btn-sm btn-info display-inline-block' href=" {{ route('admin.tax.edit', [$t->id]) }} " ><i class="fa fa-edit"></i></a> 
                                                    <form data-btn-save='{{__("Continue")}}' data-btn-cancel='{{__("Cancel")}}' data-class='error-modal' data-confirm='{{ __("Are you sure that delete the tax: :name?", ['name' => $t->name]) }}' class='display-inline-block' method="POST" action="{{ route('admin.tax.destroy', $t->id) }}"> @csrf @method('DELETE') 
                                                        <button title='{{ __('Delete tax') }}' class="btn-sm btn btn-danger"><i class='fa fa-trash'></i></button>
                                                    </form>
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
            </div>
            </div>
        @else
            
                <div class="card">
                    <div class="card-body">
                        <p>{!! __('Hi :name ! There are no taxes to be shown, create your first tax',[
                            'name' => Auth::user()->name
                        ]) !!}</p>

                    </div>
                </div>
            
        @endif
 
@endsection