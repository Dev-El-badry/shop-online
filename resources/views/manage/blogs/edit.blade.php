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
  .box-options {
    border: 1px solid red;
    padding-left: 0px;
    width: 100%;
    margin: 10px auto;
    text-align: center;
    padding-top: 14px;
  }

.box-options>.form-group {
    display: inline-block;
    margin-left: 50px;
}
</style>

@endsection

@section('content')

<h1 class="manage_title">
<i class="fa fa-plus"></i>
{{ trans('blog.update_blog') }}

<small>{{ unserialize($blog->blog_title)[LaravelLocalization::getCurrentLocale()] }}</small>
</h1>


{{-- Start Section Options --}}
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-gear"></i> &nbsp;{{ trans('items.options') }}</h3>
  </div><!-- /.box-header -->
 
  
    <div class="box-body">

   


    @if($blog->picture != null)
     <a href="{{ route('blogs.index') }}" class="btn btn-default"> &nbsp;{{ trans('categories.pervious_page') }}</a>
      <a href="{{ route('blogs.delete_config', $blog->id) }}" class="btn btn-danger del_img"> 
      <i class="fa fa-image fa-fw"></i>&nbsp;{{ trans('blog.delete_image') }}</a>
    @else
      <div class="callout callout-warning">
        <h4>{{ trans('items.warning') }}!</h4>
        {{ trans('blog.image_empty') }}
      </div>

      <a href="{{ route('blogs.index') }}" class="btn btn-default"> &nbsp;{{ trans('categories.pervious_page') }}</a>

      <a href="{{ route('blogs.upload_image', $blog->id) }}" class="btn btn-primary"> 
      <i class="fa fa-image fa-fw"></i>&nbsp;{{ trans('blog.upload_image') }}</a>
    @endif

      <a href="{{ route('blogs.get_cat_asign', $blog->id) }}" class="btn btn-success"> 
      <i class="fa fa-tag fa-fw"></i>&nbsp;{{ trans('blog.update_blog_category') }}</a>

    <a href="{{ route('blogs.delete_config', $blog->id) }}" class="btn btn-danger">
    <i class="fa fa-trash fa-fw"></i>&nbsp;{{ trans('blog.deleteBlog') }}</a>


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
          <h3 class="box-title" style="color: #f00">{{ trans('blog.update_blog') }}</h3>
      
        </div>
         @if($errors->any())
        <div class="error-msg">
          @foreach($errors->all() as $error)
            <p style="color: red">{{ $error }}</p>
          @endforeach
        </div>
        @endif
        {{-- Start Form --}}
        <form action="{{ route('blogs.update', $blog->id) }}" method="POST" role="form" class="form-horizontal">
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
                  <label for="title_{{ $key }}" class="col-sm-2">{{ trans('blog.title') }}  :</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="title_{{ $key }}" name="blog_title[{{ $key }}]"  dir="auto" value="{{ unserialize($blog->blog_title)[$key] }}">
                  </div>
                </div>  
                      
                <div class="form-group">
                  <label for="content_{{ $key }}" class="col-sm-2">{{ trans('blog.content') }}  :</label>
                  <div class="col-sm-10">
                   <textarea id="editor_{{ $key }}" id="content_{{ $key }}" name="blog_content[{{ $key }}]" rows="10" cols="80" dir="auto" >
                              {{ unserialize($blog->blog_content)[$key] }}             
                    </textarea>
                  </div>
                </div>

            
              </div>

              @endforeach
        <input type="hidden" name="blog_url" id="blog_url" />
            </div>
            <!-- /.tab-content -->
          </div>


        {{-- End Custom Tabs --}}

        <div class="box-options">
          <div class="form-group">
             <label>
                  <input type="radio" name="status" value="0" class="minimal" checked>
                  {{ trans('blog.save_darft') }}
              </label>
          </div>
           <div class="form-group">
             <label>
                  <input type="radio" name="status" value="0" class="minimal" checked>
                  {{ trans('blog.publish') }}
              </label>
          </div>
        </div>

        <div class="form-group">
          <label for="author" class="col-sm-2">{{ trans('blog.author') }} <span style="color: green">({{ trans('items.optional') }})</span>:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="author" name="author" placeholder="" value="{{ $blog->author }}">
          </div>
        </div>

        <div class="form-group">
          <label for="keywords" class="col-sm-2">{{ trans('blog.keywords') }} <span style="color: green">({{ trans('items.optional') }})</span>:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="keywords" name="keywords" placeholder="{{ trans('blog.enter_keywords') }}" value="{{ $blog->keywords }}">
          </div>
        </div>




        <div class="form-group">
          <label for="blog_description" class="col-sm-2">{{ trans('blog.description') }} <span style="color: green">({{ trans('items.optional') }})</span>:</label>
          <div class="col-sm-10">
          <textarea name="blog_description" id="blog_description" rows="10" class="form-control">{{ $blog->blog_description }}</textarea>
          </div>
        </div>


    


        
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

@if($blog->picture != null)

{{-- Start Section Options --}}
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-image"></i> &nbsp;{{ trans('items.item_image') }}</h3>
  </div><!-- /.box-header -->
 
  
    <div class="box-body">

      <img src="{{ asset('blog_pics/'.$blog->picture) }}" class="img-responsive img-thumbnaill">

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

  });
</script>

<script>
      $('.del_img').on('click', function(event) {
      event.preventDefault();
      var result = confirm("{!! trans('items.msg_ok') !!}");

      if(result)
      {
        //do something

      var obj = {
        "_token": "{{ csrf_token() }}",
        id: {!! $blog->id !!}
      };

      var target_url = '{!! route('blogs.delete_image') !!}';

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
</script>

<script>


$(document).ready(function() {

  $('#blog_url').val(convertToSlug($('#title_en').val()));


  $('#title_en').keyup(function() {
    var slug = convertToSlug($(this).val());
    $('#blog_url').val(slug);
  });


});
</script>

@endsection