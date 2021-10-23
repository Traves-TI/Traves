<?
    $SHOW_SIDEBAR = false;
?>
@extends('admin.app')

@section('content') 

@include('admin.parts.alerts')
<div class="table-responsive">

    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
        @if(Auth::user()->id == 1)
        <div class="card">
            <div class="card-body text-right">
                    <a class='btn btn-info btn-lg' href='{{route('admin.companies.create')}}'>{{__("Create company")}}</a>
                </div>
            </div>
    @endif        
    @if(isset($companies) AND $companies->count() > 0)
        
            <div class="card">
                <div class="card-body">   
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" style="width: 100%;">
                            
                                <thead>
                                    <tr role="row">
                                        <th tabindex="0" rowspan="1" colspan="1" >{{ __('Name') }}</th>
                                        <th tabindex="0" rowspan="1" colspan="1">{{ __('Email') }}</th>
                                        <th tabindex="0" rowspan="1" colspan="1">{{ __('Phone') }}</th>
                                        <th tabindex="0" rowspan="1" class="text-center" colspan="1"> {{ __('Operations') }} </th>
                                    </tr>
                                </thead>

                                <tbody>
                                
                                    
                                @foreach($companies as $company)
                                    
                                    <tr class="odd">
                                        <td >{{ $company->name }}</td>
                                        <td>{{ $company->email }}</td>
                                        <td>{{ $company->phone }}</td>
                                        <td class="text-center">
                                                <a title='{{ __('Select company') }}' class='btn btn-sm btn-warning display-inline-block' href=" {{ route('admin.companies.show', [$company->id]) }} " ><i class="fa fa-check"></i></a> 
                                                <a title='{{ __('Edit company') }}' class='btn btn-sm btn-info display-inline-block' href=" {{ route('admin.companies.edit', [$company->id]) }} " ><i class="fa fa-edit"></i></a> 
                                                <form data-confirm='{{ __("Are you sure that delete :name?", ['name' => $company->name]) }}' class='display-inline-block' method="POST" action="{{ route('admin.companies.destroy', $company->id) }}"> @csrf @method('DELETE') 
                                                    <button title='{{ __('Delete company') }}' class="btn-sm btn btn-danger"><i class='fa fa-trash'></i></button>
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
            {{ $companies->appends(request()->query())->links() }}
        </div>
        </div>

        @else
        @if(Auth::user()->id != 1)
            <div class="card">
                <div class="card-body">
                    <p>{!! __('Hi :name ! There are no companies to be shown, create your first company <a href=":url">here</a>',[
                        'name' => Auth::user()->name,
                        'url' => route('admin.companies.create')
                    ]) !!}</p>

                </div>
            </div>
        @endif
        @endif
   


@endsection