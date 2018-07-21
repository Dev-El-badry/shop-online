@extends('layouts.manage')

@section('styles')
<style>
	.options {
		padding: 5px 10px;
    	width: 450px;
    	margin-left: 9px;
    	
	}

	#select-options
	{
		margin-bottom: 70px;
	}

</style>
@endsection

@section('content')
<h1><i class="fa fa-plus"></i> &nbsp;{{ trans('categories.add_category') }}</h3></h1>
{{-- Start Section Add Category --}}
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-gear"></i> &nbsp;{{ trans('categories.add_category') }}</h3>
  </div><!-- /.box-header -->
 	
 	@if($errors->any())
    <div class="error-msg">
      @foreach($errors->all() as $error)
        <p style="color: red">{{ $error }}</p>
      @endforeach
    </div>
    @endif

    @if (Session::has('item'))
	    <div class="alert alert-success">
	        {{ session('item') }}
	    </div>
	@endif


  	<form action="{{ route('category.store') }}" method="POST">
  	{{ csrf_field() }}
    <div class="box-body">

	<div class="col-md-12">
	<div class="form-group" id="select-options">
		<label for="cat_parent" class="col-sm-2">{{ trans('categories.category_parent') }} </label>
	    	{!! Form::select('cat_parent_id', $data['options'], '', ['class'=>' col-sm-8 options', 'id'=> 'cat_parent']) !!}
	    </div>
	</div>


	@foreach(LaravelLocalization::getSupportedLocales() as $key=>$value)
	<div class="col-md-6 col-sm-12">
		<div class="form-group">
			<label for="category_{{ $key }}" class="col-sm-4">{{ trans('categories.category_title_in') }} {{ $value['native'] }}</label>
			<div class="col-md-8">
				<input type="text" class="form-control" id="category_{{ $key }}" name="cat_title[{{ $key }}]" dir="auto">
			</div>
		</div>
	</div>
	@endforeach

    </div><!-- /.box-body -->

    <div class="box-footer text-center">
        <button type="submit" class="btn btn-primary" name="submit" value="Submit">{{ trans('items.submit') }}</button>

      <button type="submit" class="btn btn-bg btn-danger" name="submit" value="Cancel">{{ trans('items.cancel') }}</button>
    </div>
    </form>

</div>

@endsection