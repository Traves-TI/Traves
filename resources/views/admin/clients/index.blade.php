
@extends('admin.app')

@section('content') 

    @if(isset($clients) AND $clients->count() > 0)
    @include('admin.parts.alerts')
    <div class="table-responsive">

        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="card">
                <div class="card-body">

               
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="dataTables_length" id="dataTable_length">
                            <label>{{__('Items per page')}}  <select name="dataTable_length" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm display-inline-block">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select></label>
                            </div>
                        </div>
                    <div class="col-sm-12 col-md-6">
                        <div id="dataTable_filter" class="dataTables_filter">
                            <label class="nowrap">Search: 
                                <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="dataTable">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="card">
            <div class="card-body">   
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                        
                            <thead>
                                <tr role="row">
                                    <th tabindex="0" rowspan="1" colspan="1" >{{ __('Name') }}</th>
                                    <th tabindex="0" rowspan="1" colspan="1">{{ __('Email') }}</th>
                                    <th tabindex="0" rowspan="1" colspan="1">{{ __('Phone') }}</th>
                                    <th tabindex="0" rowspan="1" class="text-center" colspan="1"> {{ __('Operations') }} </th>
                                </tr>
                            </thead>

                            <tbody>
                            
                                
                            @foreach($clients as $client)
                                
                                <tr class="odd">
                                    <td >{{ $client->name }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->phone }}</td>
                                    <td class="text-center">
                                            <a class='btn btn-sm btn-info display-inline-block' href=" {{ route('admin.clients.edit', [$client->id]) }} " ><i class="fa fa-edit"></i></a> 
                                            <form data-confirm='{{__("Are you sure that delete the client ") . $client->name}}' class='display-inline-block' method="POST" action="{{ route('admin.clients.destroy', $client->id) }}"> @csrf @method('DELETE') <button class="btn-sm btn btn-danger"><i class='fa fa-trash'></i></button></form>
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

    {{ $clients->links() }}

    </div>
    </div>

    @else

        <p>{{__('There are no clients registered yet.')}}</p>
    
    @endif

@endsection