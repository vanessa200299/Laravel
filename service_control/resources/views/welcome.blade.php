@extends('layouts.layout')
@section('content')

   <login-component
      :messages_prop="{{ $data["messages"]}}"
   >
   </login-component>

@endsection

@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.transit/0.9.12/jquery.transit.min.js"></script>
@stop