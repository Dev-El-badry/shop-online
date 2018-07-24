@extends('layouts.manage')

@section('content')

 <a href="{{ route('sliders.edit', $slider_id) }}" class="btn btn-default">
   &nbsp;{{ trans('categories.pervious_page') }}</a>


  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
   <i class="fa fa-upload"></i>
                &nbsp;{{ trans('slider.add_new_slide') }}
              </button>

  @include('_includes.modals.new_slide')

  {{-- Show Message Deleted --}}
@if (Session::has('item'))
    <div class="alert alert-danger" style="margin: 15px auto;">
        {{ session('item') }}
    </div>
@endif

@if($slides_count >0)
<div class="row" style="margin: 15px auto">
	<div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #f00">{{ trans('slider.slides') }}</h3>
			
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

						@forelse($slides->slides as $row)
							<tr>
							
								<td>
								<img src="{{ asset('slides/'.$row->picture) }}" 
								class="img-responsive img-thumbnaill">
								</td>
								
								
								<td class="pull-right">
							
									<a href="{{ route('slides.view', $row->id) }}" class="btn btn-default">
									<i class="fa fa-edit fa-fw"></i> &nbsp;
									{{ trans('items.edit') }}</a>
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