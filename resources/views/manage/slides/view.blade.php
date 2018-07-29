@extends('layouts.manage')

@section('content')


<h1 class="manage_title">
<i class="fa fa-plus"></i>
{{ trans('slider.update_slide') }}
</h1>


  <a style="margin: 10px auto; " href="{{ route('slides.update_group', $slide->parent_id) }}" class="btn btn-default">
   &nbsp;{{ trans('categories.pervious_page') }}</a>

{{-- Start Section Options --}}
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-gear"></i> &nbsp;{{ trans('items.options') }}</h3>
  </div><!-- /.box-header -->
 
  
    <div class="box-body">


    @if($slide->picture == NULL)
   <a href="{{ route('slides.upload_image', $slide->id) }}" class="btn btn-primary">
   <i class="fa fa-upload"></i>
   &nbsp;{{ trans('slider.upload_image') }}</a>
   @else
    <img src="{{ asset('slides/'.$slide->picture) }}" style="margin: 10px auto" class="img-responsive img-thumbnaill">
   @endif

           <a href="{{ route('slides.delete_config', $slide->id) }}" class="btn btn-danger">
   <i class="fa fa-trash"></i>
         &nbsp;{{ trans('slider.delete_config') }}</a>

    </div><!-- /.box-body -->

</div>


{{-- Show Message Success --}}
@if (Session::has('item'))
    <div class="alert alert-success">
        {{ session('item') }}
    </div>
@endif




@endsection