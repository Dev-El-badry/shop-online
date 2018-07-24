@extends('layouts.manage')


@section('content')

<h1 class="manage_title">
<i class="fa fa-plus"></i>
{{ trans('slider.add_slider') }}
</h1>

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
          <h3 class="box-title" style="color: #f00">{{ trans('slider.add_slider') }}</h3>
      
        </div>
         @if($errors->any())
        <div class="error-msg">
          @foreach($errors->all() as $error)
            <p style="color: red">{{ $error }}</p>
          @endforeach
        </div>
        @endif
        {{-- Start Form --}}
        <form action="{{ route('sliders.store') }}" method="POST" role="form" class="form-horizontal">
        {{ csrf_field() }}

       

        <!-- /.box-header -->
        <div class="box-body">

        
        <div class="form-group">
          <label for="author" class="col-sm-2">{{ trans('slider.slider_title') }} :</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="author" name="slider_title" placeholder="" value="{{ old('slider_title') }}">
          </div>
        </div>

        <div class="form-group">
          <label for="author" class="col-sm-2">{{ trans('slider.target_url') }} :</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="author" name="target_url" placeholder="" value="{{ old('target_url') }}">
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

