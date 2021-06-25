@extends('core::page.content')
@section('inner-title', __('pengumuman::general.create.title', ['attribute' => $title]) . ' - ')
@section('mPengumuman', 'opened')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.1/flatpickr.min.css">
@endsection

@section('js')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.4/holder.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.1/flatpickr.min.js"></script>
	<script>
		$().ready(function () {
			$('.flatpickr').flatpickr({
    			dateFormat: "Y-m-d",
			});
		});
	</script>
	@include('core::layouts.components.tinymce')
@endsection

@section('content')
	<section class="box-typical">

		{!! Form::open(['route' => "$prefix.store", 'autocomplete' => 'off', 'files' => true]) !!}

	    	@include('core::layouts.components.top', [
                'judul' => __('pengumuman::general.create.title', ['attribute' => $title]),
                'subjudul' =>  __('pengumuman::general.create.desc'),
                'kembali' => route("$prefix.index")
            ])
	    
	        <div class="card">
                @include("$view.form")
                @include('core::layouts.components.submit')
            </div>

	    {!! Form::close() !!}

	</section>
@endsection