@extends(config('app.interface').'errors.layout')

@section('content')
	@include(config('app.interface').'errors.partial', ['number' => '404'])
@endsection
