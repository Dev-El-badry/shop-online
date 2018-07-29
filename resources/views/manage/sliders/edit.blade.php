@extends('layouts.manage')


@section('content')

<h1 class="manage_title">
<i class="fa fa-plus"></i>
{{ trans('slider.update_slider') }}
</h1>

{{-- Start Section Options --}}
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-gear"></i> &nbsp;{{ trans('items.options') }}</h3>
  </div><!-- /.box-header -->
 
  
    <div class="box-body">

    <a href="{{ route('sliders.index') }}" class="btn btn-default">
   &nbsp;{{ trans('categories.pervious_page') }}</a>

   <a href="{{ route('slides.update_group', $slider->id) }}" class="btn btn-primary">
   <i class="fa fa-upload"></i>
   &nbsp;{{ trans('slider.upload_slides') }}</a>

    <a href="{{ route('sliders.delete_config', $slider->id) }}" class="btn btn-danger">
    <i class="fa fa-trash"></i>
    &nbsp;{{ trans('slider.delete_slider') }}</a>

    </div><!-- /.box-body -->

</div>

{{-- Show Message Success --}}
@if (Session::has('item'))
    <div class="alert alert-success">
        {{ session('item') }}
    </div>
@endif


<div class="row">
  <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #f00">{{ trans('slider.update_slider') }}</h3>
      
        </div>
         @if($errors->any())
        <div class="error-msg">
          @foreach($errors->all() as $error)
            <p style="color: red">{{ $error }}</p>
          @endforeach
        </div>
        @endif
        {{-- Start Form --}}
        <form action="{{ route('sliders.update', $slider->id) }}" method="POST" role="form" class="form-horizontal">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

       

        <!-- /.box-header -->
        <div class="box-body">

        
        <div class="form-group">
          <label for="author" class="col-sm-2">{{ trans('slider.slider_title') }} :</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="author" name="slider_title" placeholder="" value="{{ $slider->slider_title }}">
          </div>
        </div>

{{--         <div class="form-group">
          <label for="author" class="col-sm-2">{{ trans('slider.target_url') }} :</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="author" name="target_url" placeholder="" value="{{ $slider->target_url }}">
          </div>
        </div>
      --}}
        
        </div>
        <!-- /.box-body -->

        {{-- Start Box Footer --}}
        
        <div class="box-footer text-center">
          <button type="submit" class="btn btn-lg btn-primary" name="submit" value="Submit">{{ trans('items.submit') }}</button>
          <button type="submit" class="btn btn-lg btn-danger" name="submit" value="Cancel">{{ trans('items.cancel') }}</button>
        </div>

      </form>
      {{-- End Form --}}  

      </div>
      <!-- /.box -->
    </div>
</div>


@endsection

