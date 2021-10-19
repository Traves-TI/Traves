
@extends('admin.app')

@section('content') 
    @if(isset($clients) AND $clients->count() > 0)

        @foreach($clients as $client)
            {{ $client->name }}
        @endforeach

    @else

        <p>{{__('There are no clients registered yet.')}}</p>
    
    @endif

@endsection