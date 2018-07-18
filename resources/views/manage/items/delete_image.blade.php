@extends('layouts.manage')

@section('content')

{{-- Start Section Upload Image --}}

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-gear"></i> &nbsp;{{ trans('items.options') }}</h3>
  </div><!-- /.box-header -->

  	{!! Form::open(['route'=> ['items.del_img', $id] ,'method'=>'POST']) !!}
    <div class="box-body">

     <p style="color: green; ">{{ trans('items.delete_image_title') }}</p>

     

    </div><!-- /.box-body -->

    <div class="box-footer">
	    <button type="submit" class="btn btn-primary" name="submit" value="Upload">Upload Image</button>
	    <button type="submit" class="btn btn-danger" name="submit" value="Cancel">Cancel</button>
	 </div>
  {!! Form::close() !!}

</div>





@endsection