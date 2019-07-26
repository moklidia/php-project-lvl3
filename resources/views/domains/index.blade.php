@extends('layouts.app')

@section('title')
Domain
@endsection

@section('content')

@foreach($domains as $domain)
<ul>
	<li><a href="{{ route('domain', ['id' => $domain->id]) }}">{{ $domain->name }}</a></li>
</ul>
@endforeach

{{ $domains->links() }}

@endsection