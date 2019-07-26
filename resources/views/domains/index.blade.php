@extends('layouts.app')

@section('title')
Domain
@endsection

@section('content')

@foreach($domains as $domain)
<ul>
	<li>{{ $domain->name }}</li>
</ul>
@endforeach

@endsection