@extends('layouts.manage')

@section('content')

{{-- Start Section Upload Image --}}

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-gear"></i> &nbsp;{{ trans('user.del') }}</h3>
  </div><!-- /.box-header -->
 	@if($errors->any())
    <div class="error-msg">
      @foreach($errors->all() as $error)
        <p style="color: red">{{ $error }}</p>
      @endforeach
    </div>
    @endif
  	{!! Form::open(['route'=> ['users.destroy', $user_id] ] ) !!}
  	{{ csrf_field() }}
  	{{ method_field('DELETE') }}
    <div class="box-body">

     <p style="color: red; font-size: 16px; padding: 5px 5px ">{!! trans('user.del_user_sub') !!}</p>



    </div><!-- /.box-body -->

    <div class="box-footer">
	    <button type="submit" class="btn btn-danger" name="submit" value="Yes - I want Delete User">{{ trans('user.submit_del') }}</button>
	    <button type="submit" class="btn btn-primary" name="submit" value="Finished">{{ trans('items.finished') }}</button>
	 </div>
    {!! Form::close() !!}

</div>





@endsection