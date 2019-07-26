@extends('layouts.app')

@section('title')
Domain
@endsection

@section('content')

<td>
	<tr>{{ $domain->id }}</tr>
	<tr>{{ $domain->name }}</tr>
</td>


@endsection