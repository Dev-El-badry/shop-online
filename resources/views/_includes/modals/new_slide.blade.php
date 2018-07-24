<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
  <form action="{{ route('slides.store', $slider_id) }}" method="POST">
  {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ trans('slider.add_new_record') }}</h4>
      </div>
      <div class="modal-body">
        
         <div class="form-group">
          <label for="target_url" class="col-sm-4">{{ trans('slider.target_url') }} :</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="target_url" name="target_url" placeholder="">
          </div>
        </div>
 <div class="clearfix"></div><br>
         <div class="form-group">
          <label for="text_alt" class="col-sm-4">{{ trans('slider.text_alt') }} :</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="text_alt" name="alt_text" placeholder="" >
          </div>
        </div>

        <div class="clearfix"></div>

      </div>
      <div class="modal-footer">
        <button type="button"  class="btn btn-default pull-left" data-dismiss="modal">{{ trans('slider.close') }}</button>
        <button type="submit" name="submit" value="Submit" class="btn btn-primary">{{ trans('slider.save_change') }}</button>
      </div>
    </div>
    <!-- /.modal-content -->
    </form>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->