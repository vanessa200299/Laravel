@extends('layouts.layout')
@section('content')

   <admin-component
    :users_prop="{{ $data["users"]}}"
   >
   </admin-component>

@endsection

@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.transit/0.9.12/jquery.transit.min.js"></script>
@stop