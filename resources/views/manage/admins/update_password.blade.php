@extends('layouts.manage')


@section('content')

<h1 class="manage_title">
<i class="fa fa-plus"></i>
{{ trans('admins.update_password') }}
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
          <h3 class="box-title" style="color: #f00">{{ trans('admins.update_password') }}</h3>
      
        </div>
         @if($errors->any())
        <div class="error-msg">
          @foreach($errors->all() as $error)
            <p style="color: red">{{ $error }}</p>
          @endforeach
        </div>
        @endif
        {{-- Start Form --}}
        <form action="{{ route('admins.submit_password', $update_id) }}"  method="POST" role="form" class="form-horizontal">
        {{ csrf_field() }}

       

        <!-- /.box-header -->
        <div class="box-body">



        <div class="row">
          <div class="col-md-8 col-sm-12">


         <div class="form-group">
          <label for="password" class="col-sm-2">{{ trans('admins.password') }}:</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="password" name="password" placeholder="" autocomplete="off">
          </div>
        </div>

    

         <div class="form-group">
          <label for="password_confirmation" class="col-sm-2">{{ trans('admins.password_confirmation') }}:</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="off">
          </div>
        </div>

         


         
        </div>



        </div> <!-- End .col-md-8 -->


      </div> <!-- End .row -->





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
