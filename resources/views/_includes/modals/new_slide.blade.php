<div class="modal modal-primary fade" id="modal-info">
  <div class="modal-dialog modal-lg">
  
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ trans('slider.add_new_record') }}</h4>
      </div>
      <div class="modal-body" id="modal-products">
      <a href="{{ route('items.create') }}" style="margin-bottom: 10px" class="btn btn-primary">
      <i class="fa fa-plus"></i> &nbsp;{{ trans('items.add_new_product') }}</a>
          <div class="input-group" style="margin-bottom: 20px">
          <input type="text" style="width: 250px" name="query" id="query" placeholder="{{ trans('items.search') }}.." class="form-control">
        </div>
      <table class="table">
          <thead>
            <tr>
              <th>{{ trans('blog.id') }}</th>
              <th>{{ trans('items.title') }}</th>
              <th>{{ trans('items.price') }}</th>
              <th>{{ trans('items.was_price') }}</th>
              <th>{{ trans('items.status') }}</th>
              
              <th></th>
            </tr>
          </thead>

          <tbody id="products-list">

            @forelse($items as $row)
              <tr>
              <td>{{ $row->id }}</td>
                <td>{{ unserialize($row->item_title)[LaravelLocalization::getCurrentLocale()] }}</td>
                <td>{{ $row->item_price }} {!! $currencySymbol !!}</td>
                <td>{{ $row->was_price }} {!! $currencySymbol !!}</td>
                <td>{!! $row->status == 1 ? '<small class="label label-primary">'.trans('items.active') .'</label>' : '<small class="label label-danger">'.trans('items.inactive').'</label>' !!}</td>
               
                <td class="pull-right">
                  {{-- <a href="{{ route('items.show', $row->id) }}" class="btn btn-default">
                  <i class="fa fa-eye fa-fw"></i> &nbsp;
                  {{ trans('items.show') }}</a> --}}
                  <a href="#" class="btn btn-primary select_item" data-id="{{ $row->id }}">
                  <i class="fa fa-hand-grab-o fa-fw"></i> &nbsp;
                  {{ trans('items.select') }}</a>
                </td>
              </tr>

            @empty
            <tr>
              <td>
              <p style="color: red;">{{ trans('items.empty') }}</p>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>

      </div>

    </div>
    <!-- /.modal-content -->
  
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal --> 


