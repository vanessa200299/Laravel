@extends('layouts.layout')
@section('content')

   <services-component
    :user_prop="{{ $data["user"]}}"
    :services_prop="{{ $data["services"]}}"
   >
   </services-component>

@endsection

@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.transit/0.9.12/jquery.transit.min.js"></script>
@stop