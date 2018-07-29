@extends('layouts.manage')


@section('content')

<h1 class="manage_title">
<i class="fa fa-plus"></i>
{{ trans('admins.update_info') }}
</h1>


{{-- Start Section Options --}}
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-gear"></i> &nbsp;{{ trans('items.options') }}</h3>
  </div><!-- /.box-header -->
 
    <div class="box-body">
      <a href="{{ route('admins.update_password', $admin->id) }}" class="btn btn-primary">
      <i class="fa fa-key"></i>
      &nbsp;{{ trans('admins.update_password') }}</a>
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
          <h3 class="box-title" style="color: #f00">{{ trans('admins.update_info') }}</h3>
      
        </div>
         @if($errors->any())
        <div class="error-msg">
          @foreach($errors->all() as $error)
            <p style="color: red">{{ $error }}</p>
          @endforeach
        </div>
        @endif
        {{-- Start Form --}}
        <form action="{{ route('admins.update_admin', $update_id) }}"  method="POST" role="form" class="form-horizontal">
        {{ csrf_field() }}

       

        <!-- /.box-header -->
        <div class="box-body">



        <div class="row">
          <div class="col-md-8 col-sm-12">


         <div class="form-group">
          <label for="name" class="col-sm-2">{{ trans('admins.name') }}:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" placeholder="" value="{{ $admin->name }}">
          </div>
        </div>

    

         <div class="form-group">
          <label for="email" class="col-sm-2">{{ trans('admins.email') }}:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="email" name="email" placeholder="" value="{{ $admin->email }}">
          </div>
        </div>

          <div class="form-group">
          <label for="job_title" class="col-sm-2">{{ trans('admins.job_title') }}:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="job_title" name="job_title" placeholder="" value="{{ $admin->job_title }}">
          </div>
        </div>


         
        </div>



        </div> <!-- End .col-md-8 -->


      </div> <!-- End .row -->





        <!-- /.box-body -->

        {{-- Start Box Footer --}}
        
        <div class="box-footer">
          <button type="submit" class="btn btn-lg btn-primary" name="submit" value="Submit">{{ trans('items.submit') }}</button>
          {{-- <button type="submit" class="btn btn-lg btn-danger" name="submit" value="Cancel">{{ trans('items.cancel') }}</button> --}}
        </div>

      </form>
      {{-- End Form --}}  

      </div>
      <!-- /.box -->
    </div>
</div>


@endsection
