@extends('app')

@section('content')
<div class="w3-content w3-padding-top">
	<h2>Artists <small class="w3-right"><a class="nav-link" href="{{ url('new') }}">New artist</a></small> </h2>
	<ul class="w3-ul w3-large">
		@foreach ($artists as $artist => $value)
        	<li><a href="{{$value->name}}">{{$value->name}}</a></li>
        @endforeach
	</ul>
	<div class="w3-row w3-margin-top">
		{{$artists->links()}}
	</div>
</div>
@endsection