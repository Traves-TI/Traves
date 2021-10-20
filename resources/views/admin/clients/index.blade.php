
@extends('admin.app')

@section('content') 

    @if(isset($clients) AND $clients->count() > 0)

    <div class="table-responsive">

        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_length" id="dataTable_length">
                        <label>Show  <select name="dataTable_length" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select> entries</label>
                        </div>
                    </div>
                <div class="col-sm-12 col-md-6">
                    <div id="dataTable_filter" class="dataTables_filter">
                        <label>Search: 
                            <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="dataTable">
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                       
                        <thead>
                            <tr role="row">
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending">{{ __('Name') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1">{{ __('Email') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1">{{ __('Phone') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1">{{ __('Zip Code') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1">{{ __('City') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"> {{ __('Created at') }} </th></tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th rowspan="1" colspan="1">{{ __('Name') }}</th>
                                <th rowspan="1" colspan="1">{{ __('Email') }}</th>
                                <th rowspan="1" colspan="1">{{ __('Phone') }}</th>
                                <th rowspan="1" colspan="1">>{{ __('Zip Code') }}</th>
                                <th rowspan="1" colspan="1">{{ __('City') }}</th>
                                <th rowspan="1" colspan="1">{{ __('Created at') }}</th></tr>
                        </tfoot>
                        <tbody>
                        
                            
                        @foreach($clients as $client)
                            
                            <tr class="odd">
                                <td class="sorting_1">{{ $client->name }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->phone }}</td>
                                <td>{{ $client->zip_code }}</td>
                                <td>{{ $client->city }}</td>
                                <td>{{ date('d/m/Y H:i', strtotime($client->created_at)) }}</td>
                            </tr>
                        @endforeach

                        
                             
                        </tbody>
                    </table>
                </div>
            </div>

        <div class="row">
            <div class="col-sm-12 col-md-5">
                <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">Showing 1 to 50 of 57 entries</div>
            </div>
            <div class="col-sm-12 col-md-7">
                <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                    <ul class="pagination">
                        <li class="paginate_button page-item previous disabled" id="dataTable_previous">
                            <a href="#" aria-controls="dataTable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
                        </li>
                        <li class="paginate_button page-item active">
                            <a href="#" aria-controls="dataTable" data-dt-idx="1" tabindex="0" class="page-link">1</a>
                        </li>
                        <li class="paginate_button page-item ">
                            <a href="#" aria-controls="dataTable" data-dt-idx="2" tabindex="0" class="page-link">2</a>
                        </li>
                        <li class="paginate_button page-item next" id="dataTable_next">
                            <a href="#" aria-controls="dataTable" data-dt-idx="3" tabindex="0" class="page-link">Next</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>

    @else

        <p>{{__('There are no clients registered yet.')}}</p>
    
    @endif

@endsection