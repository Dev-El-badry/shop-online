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
{{ trans('blocks.update_block') }}
</h1>

{{-- Start Section Options --}}
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-gear"></i> &nbsp;{{ trans('items.options') }}</h3>
  </div><!-- /.box-header -->
 
  
    <div class="box-body">

    <a href="{{ route('homepage_blocks.index') }}" class="btn btn-default">
   &nbsp;{{ trans('categories.pervious_page') }}</a>

   <a href="{{ route('homepage_offers.update', $homepage_block->id) }}" class="btn btn-primary">
   <i class="fa fa-upload"></i>
   &nbsp;{{ trans('blocks.update_offer') }}</a>

           <a href="{{ route('homepage_blocks.delete_config', $homepage_block->id) }}" class="btn btn-danger">
   <i class="fa fa-trash"></i>
         &nbsp;{{ trans('blocks.delete_block') }}</a>

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
          <h3 class="box-title" style="color: #f00">{{ trans('blocks.update_block') }}</h3>
      
        </div>
         @if($errors->any())
        <div class="error-msg">
          @foreach($errors->all() as $error)
            <p style="color: red">{{ $error }}</p>
          @endforeach
        </div>
        @endif
        {{-- Start Form --}}
        <form action="{{ route('homepage_blocks.update', $homepage_block->id) }}" method="POST" role="form" class="form-horizontal">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

       

        <!-- /.box-header -->
        <div class="box-body">

        @foreach(LaravelLocalization::getSupportedLocales() as $key=>$value)
        <div class="form-group">
          <label for="author" class="col-sm-2">{{ trans('blocks.block_title') }} {{ $value['native'] }}:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="author" name="block_title[{{ $key }}]" placeholder="" value="{{ unserialize($homepage_block->block_title)[$key] }}">
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

