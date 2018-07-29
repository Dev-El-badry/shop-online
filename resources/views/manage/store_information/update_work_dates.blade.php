@extends('layouts.manage')

@section('styles')
<style>
	.box-date{
		margin-bottom: 20px
	}
</style>

@endsection

@section('content')
    @if (Session::has('item'))
	    <div class="alert alert-success">
	        {{ session('item') }}
	    </div>
	@endif
{{-- Start Section Add Category --}}
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-gear"></i> &nbsp;{{ trans('store_info.update_work_dates') }}</h3>
  </div><!-- /.box-header -->
 	
 	@if($errors->any())
    <div class="error-msg">
      @foreach($errors->all() as $error)
        <p style="color: red">{{ $error }}</p>
      @endforeach
    </div>
    @endif



  	<form action="{{ route('store_info.submit_update', ['update_id'=>$update_id, 'date_id'=>$date->id]) }}" method="POST">
  	{{ csrf_field() }}
    <div class="box-body">

	  <?php  
	  $options = array(
	    '0'=> trans('store_info.close'),
	    '1'=> trans('store_info.open')
	  );
	  ?>

    <div class="col-sm-12 box-date">
    
       <div class="form-group">
       <div class="col-sm-4">
        <label for="inputEmail3" class="col-sm-4 control-label">{{ trans('store_info.sat') }}:</label>

        <div class="col-sm-6">
          

          {!! Form::select('sat_status', $options, $date->sat_status, ['class'=>'form-control']) !!}
        </div>
        </div>

        <div class="col-sm-4">
          <label class="col-sm-4 control-label">{{ trans('store_info.from') }}</label>
          <input type="time" class="col-sm-8" value="{{ $date->sat_from }}" id="appt-time"  name="sat_from" />
        </div>

         <div class="col-sm-4">
          <label class="col-sm-4 control-label">{{ trans('store_info.to') }}</label>
          <input type="time" id="appt-time"  class="col-sm-8" value="{{ $date->sat_to }}" id="timedate" name="sat_to" />
        </div>

      </div>
     
    </div>

     <div class="col-sm-12 box-date">
       <div class="form-group">
          <div class="col-sm-4">
        <label for="inputEmail3" class="col-sm-4 control-label">{{ trans('store_info.sun') }}:</label>

     
          <div class="col-sm-6">

          {!! Form::select('sun_status', $options, $date->sun_status, ['class'=>'form-control']) !!}
        </div>
        </div>

        <div class="col-sm-4">
          <label class="col-sm-4 control-label">{{ trans('store_info.from') }}</label>
          <input type="time" id="appt-time"  class="col-sm-8" value="{{ $date->sun_from }}" id="timedate" name="sun_from" />
        </div>

         <div class="col-sm-4">
          <label class="col-sm-4 control-label">{{ trans('store_info.to') }}</label>
          <input type="time" id="appt-time"  class="col-sm-8" value="{{ $date->sun_to }}" id="timedate" name="sun_to" />
        </div>

      </div>
    </div>

    <div class="col-sm-12 box-date">
       <div class="form-group">
       <div class="col-sm-4">
        <label for="inputEmail3" class="col-sm-4 control-label">{{ trans('store_info.mon') }}:</label>

        <div class="col-sm-6">
          

          {!! Form::select('mon_status', $options, $date->mon_status, ['class'=>'form-control']) !!}
        </div>
        </div>

        <div class="col-sm-4">
          <label class="col-sm-4 control-label">{{ trans('store_info.from') }}</label>
          <input type="time" id="appt-time"  class="col-sm-8" value="{{ $date->mon_from }}" id="timedate" name="mon_from" />
        </div>

         <div class="col-sm-4">
          <label class="col-sm-4 control-label">{{ trans('store_info.to') }}</label>
          <input type="time" id="appt-time"  class="col-sm-8" value="{{ $date->mon_to }}" id="timedate" name="mon_to" />
        </div>

      </div>
    </div>

     <div class="col-sm-12 box-date">
       <div class="form-group">
       <div class="col-sm-4">
        <label for="inputEmail3" class="col-sm-4 control-label">{{ trans('store_info.tue') }}:</label>

        <div class="col-sm-6">
          

          {!! Form::select('tue_status', $options, $date->tue_status, ['class'=>'form-control']) !!}
        </div>
        </div>

        <div class="col-sm-4">
          <label class="col-sm-4 control-label">{{ trans('store_info.from') }}</label>
          <input type="time" id="appt-time"  class="col-sm-8" value="{{ $date->tue_from }}" id="timedate" name="tue_from" />
        </div>

         <div class="col-sm-4">
          <label class="col-sm-4 control-label">{{ trans('store_info.to') }}</label>
          <input type="time" id="appt-time"  class="col-sm-8" value="{{ $date->tue_to }}" id="timedate" name="tue_to" />
        </div>

      </div>
    </div>



     <div class="col-sm-12 box-date">
       <div class="form-group">
       <div class="col-sm-4">
        <label for="inputEmail3" class="col-sm-4 control-label">{{ trans('store_info.wed') }}:</label>

        <div class="col-sm-6">
          

          {!! Form::select('wed_status', $options, $date->wed_status, ['class'=>'form-control']) !!}
        </div>
        </div>

        <div class="col-sm-4">
          <label class="col-sm-4 control-label">{{ trans('store_info.from') }}</label>
          <input type="time" id="appt-time"  class="col-sm-8" value="{{ $date->wed_from }}" id="timedate" name="wed_from" />
        </div>

         <div class="col-sm-4">
          <label class="col-sm-4 control-label">{{ trans('store_info.to') }}</label>
          <input type="time" id="appt-time"  class="col-sm-8" value="{{ $date->wed_to }}" id="timedate" name="wed_to" />
        </div>

      </div>
    </div>

    <div class="col-sm-12 box-date">
       <div class="form-group">
       <div class="col-sm-4">
        <label for="inputEmail3" class="col-sm-4 control-label">{{ trans('store_info.thu') }}:</label>

        <div class="col-sm-6">
          

          {!! Form::select('thu_status', $options, $date->thu_status, ['class'=>'form-control']) !!}
        </div>
        </div>

        <div class="col-sm-4">
          <label class="col-sm-4 control-label">{{ trans('store_info.from') }}</label>
          <input type="time" id="appt-time"  class="col-sm-8" value="{{ $date->thu_from }}" id="timedate" name="thu_from" />
        </div>

         <div class="col-sm-4">
          <label class="col-sm-4 control-label">{{ trans('store_info.to') }}</label>
          <input type="time" id="appt-time"  class="col-sm-8" value="{{ $date->thu_to }}" id="timedate" name="thu_to" />
        </div>

      </div>
    </div>


    <div class="col-sm-12 box-date">
       <div class="form-group">
        <div class="col-sm-4">

        <label for="inputEmail3" class="col-sm-4 control-label">{{ trans('store_info.fri') }}:</label>

       <div class="col-sm-6">
          

          {!! Form::select('fri_status', $options, $date->fri_status, ['class'=>'form-control']) !!}
        </div>
        </div>

        <div class="col-sm-4">
          <label class="col-sm-4 control-label">{{ trans('store_info.from') }}</label>
          <input type="time" id="appt-time"  class="col-sm-8" value="{{ $date->fri_from }}" id="timedate" name="fri_from" />
        </div>

         <div class="col-sm-4">
          <label class="col-sm-4 control-label">{{ trans('store_info.to') }}</label>
          <input type="time" id="appt-time"  class="col-sm-8" value="{{ $date->fri_to }}" id="timedate" name="fri_to" />
        </div>

      </div>
    </div>


    </div><!-- /.box-body -->
    </div>

    <div class="box-footer text-center">
        <button type="submit" class="btn btn-primary" name="submit" value="Submit">{{ trans('cat_assign.submit') }}</button>

     {{--  <button type="submit" class="btn btn-bg btn-danger" name="submit" value="Finished">{{ trans('cat_assign.finished') }}</button> --}}
    </div>
    </form>

</div>




@endsection

