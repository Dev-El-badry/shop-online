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

  img.profile-user-img {
    width: 100% !important;
  }

  .get_location {
        text-align: center;
    margin: 19px auto;
  }
</style>

@endsection

@section('content')

<h1 class="manage_title">
<i class="fa fa-plus"></i>
{{ trans('store_info.update_info') }}
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
          <h3 class="box-title" style="color: #f00">{{ trans('store_info.update_info') }}</h3>
      
        </div>
         @if($errors->any())
        <div class="error-msg">
          @foreach($errors->all() as $error)
            <p style="color: red">{{ $error }}</p>
          @endforeach
        </div>
        @endif
        {{-- Start Form --}}
        <form action="{{ route('store_info.store', $update_id) }}" enctype="multipart/form-data" method="POST" role="form" class="form-horizontal">
        {{ csrf_field() }}

       

        <!-- /.box-header -->
        <div class="box-body">


        {{-- Start Custom Tabs --}}

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              
              @foreach(LaravelLocalization::getSupportedLocales() as $key=> $value)
              <li>
              <a href="#{{ $key }}" data-toggle="tab" aria-expanded="true">{{ $value['native'] }}</a>
              </li>
              @endforeach
            </ul>
            <div class="tab-content">

              @foreach(LaravelLocalization::getSupportedLocales() as $key=> $value)
              
              <div class="tab-pane" id="{{ $key }}">

                <div class="form-group">
                  <label for="title_{{ $key }}" class="col-sm-2">{{ trans('store_info.title') }}  :</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="title_{{ $key }}" name="store_title[{{ $key }}]"  dir="auto"  value="{{ unserialize($info->store_title)[$key] }}">
                  </div>
                </div>  
                      
                <div class="form-group">
                  <label for="content_{{ $key }}" class="col-sm-2">{{ trans('store_info.description') }}  :</label>
                  <div class="col-sm-10">
                   <textarea id="editor_{{ $key }}" id="content_{{ $key }}" name="description[{{ $key }}]" rows="10" cols="80" dir="auto" >
                                      {{ unserialize($info->description)[$key] }}     
                    </textarea>
                  </div>
                </div>

            
              </div>

              @endforeach

              

            </div>
            <!-- /.tab-content -->
          </div>


        {{-- End Custom Tabs --}}

        <div class="row">
          <div class="col-md-8 col-sm-12">


         <div class="form-group">
          <label for="phone_number" class="col-sm-2">{{ trans('store_info.phone_number') }}:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="" value="{{ $info->phone_number }}">
          </div>
        </div>

    

         <div class="form-group">
          <label for="email" class="col-sm-2">{{ trans('store_info.email') }}:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="email" name="email" placeholder="" value="{{ $info->email }}">
          </div>
        </div>

          <div class="form-group">
          <label for="address1" class="col-sm-2">{{ trans('store_info.address1') }}:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="address1" name="address1" placeholder="" value="{{ $info->address1 }}">
          </div>
        </div>

          <div class="form-group">
          <label for="address2" class="col-sm-2">{{ trans('store_info.address2') }}:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="address2" name="address2" placeholder="" value="{{ $info->address2 }}">
          </div>
        </div>

         <div class="form-group">
          <label for="country" class="col-sm-2">{{ trans('store_info.country') }}:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="country" name="country" placeholder="" value="{{ $info->country }}">
          </div>
        </div>

        <div class="form-group">
          <label for="town" class="col-sm-2">{{ trans('store_info.town') }}:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="town" name="town" placeholder="" value="{{ $info->town }}">
          </div>
        </div>

        <div class="form-group">
          <label for="postal_code" class="col-sm-2">{{ trans('store_info.postal_code') }}:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="postal_code" style="width: 200px" name="postal_code" placeholder="" value="{{ $info->postal_code }}">
          </div>
        </div>

         <div class="form-group">
          <label for="latitude" class="col-sm-2">{{ trans('store_info.latitude') }}:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="latitude" style="width: 200px" name="latitude" placeholder="" value="{{ $info->latitude }}">
          </div>

          <label for="longitude" class="col-sm-2">{{ trans('store_info.longitude') }}:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="longitude" style="width: 200px" name="longitude" placeholder="" value="{{ $info->latitude }}">
          </div>

         
        </div>

        <div class="get_location">
           <p style="color: green" id="demo">{{ trans('store_info.msg_other') }}</p>
            <button class="btn btn-info btn-sm" id="get-location">
              {{ trans('store_info.get_location') }}
            </button>

            <button class="btn btn-default btn-sm" id="reset" style="display: none">
              {{ trans('store_info.reset') }}
            </button>
        </div>

        </div> <!-- End .col-md-8 -->

        <div class="col-md-4 col-sm-12">
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive " src="{{ $info->picture == null ?  asset('img/default.png') : asset('store_pics/'.$info->picture.'') }}" alt="User profile picture">

             

              <a href="#" class="btn btn-primary btn-block" id="upload-img"><b>{{ trans('store_info.upload_img') }}</b></a>

              <input type="file" style="display: none;" name="file" id="thumb-file">
            </div>
            <!-- /.box-body -->
          </div>
        </div>
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

@section('scripts')
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script src="{{ asset('js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
 <script>
      $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor_en');
        CKEDITOR.replace('editor_ar');
        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();
      });
    </script>
<script>

  $(document).ready(function() {

    $('.nav-tabs li:first-child').addClass('active');
    $('.tab-content div:first-child').addClass('active');

  });
</script>


<script>
  
$(document).ready(function() {


$('#upload-img').on('click', function(event) {
  event.preventDefault();

  $('#thumb-file').click();
});

$('#thumb-file').on('change', function() {
  readURL(this);
});

function readURL(input)
{
  if(input.files && input.files[0])
  {
    var file = input.files[0];


    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function(e) {
      $('.profile-user-img').attr('src', e.target.result);
    };
  }
}

});

$("#get-location").on('click', function(event) {
  event.preventDefault();
 
  geolocation();
});

//geo location function
function geolocation()
{
  
  if(navigator.geolocation) {

    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    $('#demo').innerText('Geolocation is not supported by this browser.');
  }
}

function showPosition(position)
{

  var lat = $('#latitude').val();
  var long = $('#longitude').val();

  $('#latitude').data('val', lat);
  $('#longitude').data('val', long);

  $('#latitude').val(position.coords.latitude);
  $('#longitude').val(position.coords.longitude);

  $('#reset').css('display', 'inline-block');
}

$('#reset').on('click', function (event) {
  event.preventDefault();
  var lat = $('#latitude').data('val');
  var long = $('#longitude').data('val');


  $('#latitude').val(lat);
  $('#longitude').val(long);

  $(this).css('display', 'none');
});


</script>


@endsection