@extends('layouts.app')

@section('title')
Domain
@endsection

@section('content')

<table class="table table-bordered">
<thead>
	<th scope="col">URL</th>
	<th scope="col">Status Code</th>
	<th scope="col">Content Length</th>
	<th scope="col">H1</th>
	<th scope="col">Keywords</th>
	<th scope="col">Description</th>
</thead>
<tbody>
<tr>
	<td>{{ $domain->name }}</td>
	<td>{{ $domain->statusCode }}</td>
	<td>{{ $domain->contentLength }}</td>
	<td>{{ $domain->h1 }}</td>
	<td>{{ $domain->keywords }}</td>
	<td>{{ $domain->description }}</td>
</tr>
</tbody>
</table>


@endsection