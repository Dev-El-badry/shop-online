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


<div class="row">
  <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #f00">{{ trans('slider.update_info_slide') }}</h3>
      
        </div>
         @if($errors->any())
        <div class="error-msg">
          @foreach($errors->all() as $error)
            <p style="color: red">{{ $error }}</p>
          @endforeach
        </div>
        @endif
        {{-- Start Form --}}
        <form action="{{ route('slides.update', $slide->id) }}" method="POST" role="form" class="form-horizontal">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

       

        <!-- /.box-header -->
        <div class="box-body">

        
        <div class="form-group">
          <label for="target_url" class="col-sm-2">{{ trans('slider.target_url') }} :</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="target_url" name="target_url" placeholder="" value="{{ $slide->target_url }}">
          </div>
        </div>

        <div class="form-group">
          <label for="alt_text" class="col-sm-2">{{ trans('slider.text_alt') }} :</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="alt_text" name="alt_text" placeholder="" value="{{ $slide->alt_text }}">
          </div>
        </div>
     
        
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