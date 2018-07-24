@extends('layouts.manage')

@section('styles')
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
<style>
  .width-small {
    width: 150px
  }

  option:first-child {
    display: none
  }
</style>

@endsection

@section('content')

<h1 class="manage_title">
<i class="fa fa-plus"></i>
{{ trans('blocks.add_block') }}
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
          <h3 class="box-title" style="color: #f00">{{ trans('blocks.add_block') }}</h3>
      
        </div>
         @if($errors->any())
        <div class="error-msg">
          @foreach($errors->all() as $error)
            <p style="color: red">{{ $error }}</p>
          @endforeach
        </div>
        @endif
        {{-- Start Form --}}
        <form action="{{ route('homepage_blocks.store') }}" method="POST" role="form" class="form-horizontal">
        {{ csrf_field() }}

       

        <!-- /.box-header -->
        <div class="box-body">

        @foreach(LaravelLocalization::getSupportedLocales() as $key=>$value)
        <div class="form-group">
          <label for="author" class="col-sm-2">{{ trans('blocks.block_title') }} {{ $value['native'] }}:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="author" name="block_title[{{ $key }}]" placeholder="" value="{{ old('block_title['.$key.']') }}">
          </div>
        </div>
        @endforeach
        
        </div>
        <!-- /.box-body -->

        {{-- Start Box Footer --}}
        
        <div class="box-footer">
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

