@extends('layouts.app')

@section('content')

    <payment :order="{{ $order }}"/>

@endsection
