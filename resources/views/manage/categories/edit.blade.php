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

	a.btn
	{
		margin-left: 5px;
		margin-right: 5px;
	}

</style>
@endsection

@section('content')
<h1><i class="fa fa-edit"></i> &nbsp;{{ trans('categories.update_cat') }}</h3></h1>
    @if (Session::has('item'))
	    <div class="alert alert-success">
	        {{ session('item') }}
	    </div>
	@endif
{{-- Start Section Add Category --}}
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-gear"></i> &nbsp;{{ trans('categories.update_cat') }}</h3> <small>{{ unserialize($category->cat_title)[LaravelLocalization::getCurrentLocale()] }}</small>

<a href="{{ route('cat_del_config', $category->id) }}" 
   class="btn btn-danger pull-right del_cat">
   <i class="fa fa-trash fa-fw"></i>
   &nbsp;{{ trans('categories.del_cat') }}</a>


@if($data['image'])

<a href="{{ route('delete_cat_pic', $category->id) }}" 
   class="btn btn-danger pull-right del_picture">
	<i class="fa fa-trash-o fa-fw"></i>
&nbsp;{{ trans('categories.delete_picture') }}</a>

@else

<a href="{{ route('upload_cat_pic', $category->id) }}" 
   class="btn btn-success pull-right">
	<i class="fa fa-image fa-fw"></i>
&nbsp;{{ trans('categories.upload_picture') }}</a>

@endif


  </div><!-- /.box-header -->
 	
 	@if($errors->any())
    <div class="error-msg">
      @foreach($errors->all() as $error)
        <p style="color: red">{{ $error }}</p>
      @endforeach
    </div>
    @endif




  	<form action="{{ route('category.update', $category->id) }}" method="POST">
  	{{ csrf_field() }}
  	{{ method_field('PUT') }}
    <div class="box-body">

	<div class="col-md-12">
	<div class="form-group" id="select-options">
		<label for="cat_parent" class="col-sm-2">{{ trans('categories.category_parent') }} </label>
	    	{!! Form::select('cat_parent_id', $data['options'], $category->cat_parent_id, ['class'=>' col-sm-8 options', 'id'=> 'cat_parent']) !!}
	    </div>
	</div>


	@foreach(LaravelLocalization::getSupportedLocales() as $key=>$value)
	<div class="col-md-6 col-sm-12">
		<div class="form-group">
			<label for="category_{{ $key }}" class="col-sm-4">{{ trans('categories.category_title_in') }} {{ $value['native'] }}</label>
			<div class="col-md-8">
				<input type="text" class="form-control" id="category_{{ $key }}" name="cat_title[{{ $key }}]" dir="auto" value="{{ unserialize($category->cat_title)[$key] }}">
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

@if($data['image_status'])

{{-- Start Section Options --}}
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-image"></i> &nbsp;{{ trans('categories.cat_image') }}</h3>
  </div><!-- /.box-header -->
 
  
    <div class="box-body">

      <img src="{{ asset('categories_pics/'.$data['image']) }}" class="img-responsive img-thumbnaill">

    </div><!-- /.box-body -->

</div>
@endif

@endsection

@section('scripts')
<script>
	$('.del_picture').on('click', function(event) {
		event.preventDefault();
		var cat_id = {{ $category->id }};
		var target_url = '{{ route('delete_cat_pic') }}';
		var obj = { 'cat_id': cat_id, "_token": "{{ csrf_token() }}" };

		$.post(
			target_url,
			obj,
			function (data)
			{
				if(data == 1)
				{
					window.location.reload();
				} else {
					alert("error occured please try again");
				}
			}
		);
	});
</script>
@endsection
