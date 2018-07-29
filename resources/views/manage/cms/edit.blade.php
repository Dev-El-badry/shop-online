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
{{ trans('cms.edit_cms') }} <small>{{ unserialize($webpage->page_title)[LaravelLocalization::getCurrentLocale()] }}</small>
</h1>

{{-- Start Section Options --}}
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-gear"></i> &nbsp;{{ trans('items.options') }}</h3>
  </div><!-- /.box-header -->
 
  
    <div class="box-body">

    <a href="{{ route('web_pages.index') }}" class="btn btn-default">
   
   &nbsp;{{ trans('categories.pervious_page') }}</a>

    @if($webpage->id >3)
           <a href="{{ route('cms.delete', $webpage->id) }}" class="btn btn-danger">
   
         &nbsp;{{ trans('cms.delete_page') }}</a>
    @endif

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
          <h3 class="box-title" style="color: #f00">{{ trans('cms.edit_cms') }}</h3>
      
        </div>
         @if($errors->any())
        <div class="error-msg">
          @foreach($errors->all() as $error)
            <p style="color: red">{{ $error }}</p>
          @endforeach
        </div>
        @endif
        {{-- Start Form --}}
        <form action="{{ route('web_pages.update', $webpage->id) }}" method="POST" role="form" class="form-horizontal">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
       

        <!-- /.box-header -->
        <div class="box-body">

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
                  <label for="title_{{ $key }}" class="col-sm-2">{{ trans('cms.title') }}  :</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="title_{{ $key }}" name="page_title[{{ $key }}]"  dir="auto"  value="{{ unserialize($webpage->page_title)[$key] }}">
                  </div>
                </div>  
                      
                <div class="form-group">
                  <label for="content_{{ $key }}" class="col-sm-2">{{ trans('cms.content') }}  :</label>
                  <div class="col-sm-10">
                   <textarea id="editor_{{ $key }}" id="content_{{ $key }}" name="page_content[{{ $key }}]" rows="10" cols="80" dir="auto" >
                    {{ unserialize($webpage->page_content)[$key] }}
                    </textarea>
                  </div>
                </div>

            
              </div>

              @endforeach
              <input type="hidden" name="page_url" id="page_url" />
            </div>
            <!-- /.tab-content -->
          </div>


        {{-- End Custom Tabs --}}
        

         <div class="form-group">
          <label for="page_keywords" class="col-sm-2">{{ trans('cms.keywords') }} <span style="color: green">({{ trans('items.optional') }})</span>:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="page_keywords" name="page_keywords" placeholder="{{ trans('cms.enter_keywords') }}" value="{{ $webpage->page_keywords }}">
          </div>
        </div>




        <div class="form-group">
          <label for="page_description" class="col-sm-2">{{ trans('cms.description') }} <span style="color: green">({{ trans('items.optional') }})</span>:</label>
          <div class="col-sm-10">
          <textarea name="page_description" id="page_description" rows="10" class="form-control">{{ $webpage->page_description }}</textarea>
          </div>
        </div>
    

  
        
        </div>
        <!-- /.box-body -->

        {{-- Start Box Footer --}}
        
        <div class="box-footer">
          <button type="submit" class="btn btn-lg btn-primary" name="submit" value="Submit">{{ trans('cms.save_change') }}</button>
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
   $(function () {
 $('#page_url').val(convertToSlug($('#title_en').val()));
  
  $('#title_en').keyup(function() {
    var slug = convertToSlug($(this).val());
    $('#page_url').val(slug);
  });
 });

</script>

@endsection