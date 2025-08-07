@extends('layouts.app')
@section('content_title', 'Dashboard')
@section('content')
 <div class="card">
    <div class="card-header">
        <h3 class="card-title">Welcome to POS App <strong class="capitalize">{{ auth()->user()->name }}</strong></h3>
        </div>
 </div>
@endsection