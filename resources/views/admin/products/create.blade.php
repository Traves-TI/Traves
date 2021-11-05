@extends('admin.app')

@section('content') 
   
<div class='row'>
    <div class='col-md-6'>
      @include('admin.products.form')
    </div>
</div>

@endsection