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
{{ trans('main.add_item') }}
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
          <h3 class="box-title" style="color: #f00">{{ trans('main.add_item') }}</h3>
      
        </div>
         @if($errors->any())
        <div class="error-msg">
          @foreach($errors->all() as $error)
            <p style="color: red">{{ $error }}</p>
          @endforeach
        </div>
        @endif
        {{-- Start Form --}}
        <form action="{{ route('items.store') }}" method="POST" role="form" class="form-horizontal">
        {{ csrf_field() }}

       

        <!-- /.box-header -->
        <div class="box-body">

        <div class="form-group">
          <label for="price" class="col-sm-2">{{ trans('items.price') }}:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control width-small" id="price" name="item_price" placeholder="{{ trans('items.price') }}" value="{{ old('item_price') }}">
          </div>
        </div>

         <div class="form-group">
          <label for="was_price" class="col-sm-2">{{ trans('items.was_price') }} <span style="color: green">(optional)</span>:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control width-small" id="was_price" name="was_price" placeholder="{{ trans('items.was_price') }}" value="{{ old('was_price') }}">
          </div>
        </div>

        <div class="form-group">
          <label for="status" class="col-sm-2">{{ trans('items.status') }}:</label>
          <div class="col-sm-10">
           
            {!! Form::select('status', $options, '', ['class'=>'form-control  width-small']) !!}
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
                    <input type="text" class="form-control" id="title_{{ $key }}" name="item_title[{{ $key }}]" placeholder="{{ trans('items.title') }}" dir="auto"  >
                  </div>
                </div>  
                      
                <div class="form-group">
                   <textarea id="editor_{{ $key }}" name="item_description[{{ $key }}]" rows="10" cols="80" dir="auto" >
                                           
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

@endsection