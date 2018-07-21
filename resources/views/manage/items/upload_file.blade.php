@extends('layouts.manage')

@section('content')

{{-- Start Section Upload File --}}

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-gear"></i> &nbsp;{{ trans('items.upload_file') }}</h3>
  </div><!-- /.box-header -->
 	@if($errors->any())
    <div class="error-msg">
      @foreach($errors->all() as $error)
        <p style="color: red">{{ $error }}</p>
      @endforeach
    </div>
    @endif
  	{!! Form::open(['route'=> ['fileUploadPdf', $id] , 'enctype'=> 'multipart/form-data']) !!}
    <div class="box-body">

     <p style="color: green; ">{{ trans('items.upload_pdf_title') }}</p>

     {!! Form::file('file', $attributes = array()) !!}

    </div><!-- /.box-body -->

    <div class="box-footer">
	    <button type="submit" class="btn btn-primary" name="submit" value="Upload">{{ trans('items.upload_file') }}</button>
	    <button type="submit" class="btn btn-danger" name="submit" value="Cancel">{{ trans('items.cancel') }}</button>
	 </div>
    {!! Form::close() !!}

</div>

@endsection
