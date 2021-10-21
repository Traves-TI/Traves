<?
    $SHOW_SIDEBAR = false;
?>

@extends('admin.app')

@section('content') 
    
<div class='row'>
    <div class='col-md-6'>
        @include('admin.companies.form')
    </div>
</div>
    
@endsection