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

  a.btn 
  {
    margin-bottom: 10px
  }
</style>

@endsection

@section('content')

<h1 class="manage_title">
<i class="fa fa-edit"></i>
{{ trans('items.update_item') }} <small>{{ unserialize($item->item_title)[LaravelLocalization::getCurrentLocale()] }}</smal>
</h1>

{{-- Start Section Options --}}
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-gear"></i> &nbsp;{{ trans('items.options') }}</h3>
  </div><!-- /.box-header -->
 
  
    <div class="box-body">

    @if($data['file_status'])
    <div class="callout callout-warning">
      <h4>{{ trans('items.warning') }}!</h4>
      {{ trans('items.file_empty') }}
    </div>
    @endif

    @if($data['image_status'])
      <div class="callout callout-warning">
        <h4>{{ trans('items.warning') }}!</h4>
        {{ trans('items.image_empty') }}
      </div>

    <a href="{{ route('upload_image', $item->id) }}" class="btn btn-primary">
      <i class="fa fa-image"></i> &nbsp;
      {{ trans('items.add_image') }}</a>
    @else
    
    <a href="#" class="btn btn-danger del_img">
    <i class="fa fa-image"></i> &nbsp;
    {{ trans('items.delete_image') }}</a>

    @endif

    @if($data['file_status'])
     <a href="{{ route('upload_file', $item->id) }}" class="btn btn-primary">
      <i class="fa fa-file-pdf-o fa-fw"></i> &nbsp;
      {{ trans('items.add_file') }}</a>
    @else
    <a href="#" class="btn btn-danger del_file">
    <i class="fa fa-file"></i> &nbsp;
    {{ trans('items.delete_pdf') }}</a>

    <a href="#" class="btn btn-success download_file">
    <i class="fa fa-cloud-download"></i> &nbsp;
    {{ trans('items.download_pdf') }}</a>
    @endif

    <a href="{{ route('update_color', $item->id) }}" class="btn btn-warning">
    <i class="fa fa-paint-brush fa-fw"></i> &nbsp;
    {{ trans('items.update_color') }}</a>

    <a href="{{ route('update_size', $item->id) }}" class="btn btn-info">
    <i class="fa fa-circle fa-fw"></i> &nbsp;
    {{ trans('items.update_size') }}</a>

    <a href="{{ route('update_cat_assign', $item->id) }}" class="btn btn-success">
    <i class="fa fa-tags fa-fw"></i> &nbsp;
    {{ trans('items.upload_items_cat') }}</a>

    <a href="{{ route('delete_item', $item->id) }}" class="btn btn-danger">
    <i class="fa fa-trash fa-fw"></i> &nbsp;
    {{ trans('items.item_delete') }}</a>

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
          <h3 class="box-title" style="color: #f00">{{ trans('items.update_item') }}</h3>
      
        </div>
         @if($errors->any())
        <div class="error-msg">
          @foreach($errors->all() as $error)
            <p style="color: red">{{ $error }}</p>
          @endforeach
        </div>
        @endif
        {{-- Start Form --}}
        <form action="{{ route('items.update', $item->id) }}" method="POST" role="form" class="form-horizontal">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

       

        <!-- /.box-header -->
        <div class="box-body">

        <div class="form-group">
          <label for="price" class="col-sm-2">{{ trans('items.price') }}:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control width-small" id="price" name="item_price" placeholder="{{ trans('items.price') }}" value="{{ $item->item_price }}">
          </div>
        </div>

         <div class="form-group">
          <label for="was_price" class="col-sm-2">{{ trans('items.was_price') }} <span style="color: green">({{ trans('items.optional') }})</span>:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control width-small" id="was_price" name="was_price" placeholder="{{ trans('items.was_price') }}" value="{{ $item->was_price }}">
          </div>
        </div>

        <div class="form-group">
          <label for="status" class="col-sm-2">{{ trans('items.status') }}:</label>
          <div class="col-sm-10">
         
            {!! Form::select('status', $options, [$item->status], ['class'=>'form-control  width-small']) !!}
          </div>
        </div>
        
        {{-- Start Custom Tabs --}}

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              
              @foreach(LaravelLocalization::getSupportedLocales() as $key=> $value)
              <li><a href="#{{ $key }}" data-toggle="tab" aria-expanded="true">{{ $value['native'] }}</a></li>
              @endforeach
            </ul>
            <div class="tab-content">

              @foreach(LaravelLocalization::getSupportedLocales() as $key=> $value)
              
              <div class="tab-pane" id="{{ $key }}">

                <div class="form-group">
                  <label for="title_{{ $key }}" class="col-sm-2">{{ trans('items.title') }}  :</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="title_{{ $key }}" name="item_title[{{ $key }}]" placeholder="{{ trans('items.title') }}" dir="auto" value="{{ unserialize($item->item_title)[$key] }}">
                  </div>
                </div>  
                      
                <div class="form-group">
                   <textarea id="editor_{{ $key }}" name="item_description[{{ $key }}]" rows="10" cols="80" dir="auto" >
                    {{ unserialize($item->item_description)[$key] }}
                    </textarea>
                </div>

            
              </div>

              @endforeach

            </div>
            <!-- /.tab-content -->
          </div>


        {{-- End Custom Tabs --}}
        
        </div>
        <!-- /.box-body -->

        {{-- Start Box Footer --}}
        
        <div class="box-footer">
          <button type="submit" class="btn btn-bg btn-primary" name="submit" value="Submit">{{ trans('items.submit') }}</button>
          <button type="submit" class="btn btn-danger" name="submit" value="Cancel">{{ trans('items.cancel') }}</button>
        </div>

      </form>
      {{-- End Form --}}  

      </div>
      <!-- /.box -->
    </div>
</div>

@if(!$data['image_status'])

{{-- Start Section Options --}}
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-image"></i> &nbsp;{{ trans('items.item_image') }}</h3>
  </div><!-- /.box-header -->
 
  
    <div class="box-body">

      <img src="{{ asset('items_pics/'.$data['image']) }}" class="img-responsive img-thumbnaill">

    </div><!-- /.box-body -->

</div>
@endif
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

    $('.del_img').on('click', function(event) {
      event.preventDefault();
      var result = confirm("{!! trans('items.msg_ok') !!}");

      if(result)
      {
        //do something

      var obj = {
        "_token": "{{ csrf_token() }}",
        id: {!! $item->id !!}
      };

      var target_url = '{!! route('delete_image') !!}';

      $.post(
        target_url,
        obj,
        function(data) {
          //window.location.reload();
          if(data == 1)
          {
            location.reload();
          }
          else
          {
            alert('error occured .. try again!');
          }
        },
      );

      }
    }); 

  });
</script>

<script>
$('.del_file').on('click', function(event) {
  event.preventDefault();
  var result = confirm("{!! trans('file_ok') !!}");

  if(result)
  {
    //do something

  var obj = {
    "_token": "{{ csrf_token() }}",
    id: {!! $item->id !!}
  };

  var target_url = '{!! route('delete_pdf') !!}';

  $.post(
    target_url,
    obj,
    function(data) {
      //window.location.reload();
      if(data == 1)
      {
        location.reload();
      }
      else
      {
        alert('occured mistake! try agin');
      }
    },
  );

  }
}); 
</script>

<script>
$(document).ready(function() {

  $('.download_file').on('click', function(event) {

    event.preventDefault();

    var obj = {
      "_token": "{{ csrf_token() }}",
      "pdf_file": "{{ $item->pdf_file }}"
    };

    var target_url = "{{ route('downloadFile') }}";

    $.post(
      target_url,
      obj,
      function(data) {
        if(data == 1) {
          alert('{!! trans('items.done_download') !!}');
        } else {
          alert('occured mistake! try agin');
        }
      }
    );
  }); 

});
</script>


@endsection