@extends('layouts.manage')

@section('content')

 <a href="{{ route('items.edit', $item_id) }}" class="btn btn-default">
   &nbsp;{{ trans('categories.pervious_page') }}</a>


  <a href="{{ route('item_galleries.upload_image', $item_id) }}" class="btn btn-success" >
   <i class="fa fa-upload"></i>
                &nbsp;{{ trans('items.upload_image') }}
              </a>



  {{-- Show Message Deleted --}}
@if (Session::has('item'))
    <div class="alert alert-success" style="margin: 15px auto;">
        {{ session('item') }}
    </div>
@endif

@if (Session::has('item_del'))
    <div class="alert alert-danger" style="margin: 15px auto;">
        {{ session('item_del') }}
    </div>
@endif

@if($images_count >0)
<div class="row" style="margin: 15px auto">
	<div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #f00">{{ trans('items.item_galleries') }}</h3>
			
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
			
			<!-- Start Table -->
				
				<table class="table">
					<thead>
						<tr>
						
							<th></th>
							<th></th>
						
						</tr>
					</thead>

					<tbody>

						@forelse($images as $row)
							<tr>
							
								<td>
								<img src="{{ asset('item_galleries/'.$row->picture) }}" 
								class="img-responsive img-thumbnaill">
								</td>
								
								
								<td class="pull-right">
							
									<a href="{{ route('item_galleries.delete_config', $row->id) }}" class="btn btn-danger">
									<i class="fa fa-trash fa-fw"></i> &nbsp;
									{{ trans('items.delete_image') }}</a>
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


			<!-- End Table -->

        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
</div>
@endif


@endsection