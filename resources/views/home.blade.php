@extends('layouts.app')

@section('title')
Page Analyzer
@endsection

@section('content')
<div class="jumbotron">
  <form action="domains" method="post">
    <label>Enter a domain</label>
    <input type="domain", name="name">
    <button type="submit" class="btn btn-primary">Submit</button>
  <form>
</div>
@endsection