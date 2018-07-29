@extends('layouts.manage')

@section('styles')
<style>
	#modal-products > table {
		border: 1px solid whitesmoke;
	}

	#modal-products {
		padding: 10px;
	    background-color: #fff !important;
	    color: black !important;
	    margin: 10px;
	}
</style>
@endsection

@section('content')

 <a href="{{ route('sliders.edit', $slider_id) }}" class="btn btn-default">
   &nbsp;{{ trans('categories.pervious_page') }}</a>


  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-info">
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


@section('scripts')

<script>
	$(document).ready(function() {

		$('#query').keyup(function() {
			var query = $(this).val();
			
			var obj = {
				'_token': '{{ csrf_token() }}',
				'query': query
			};
			var target_url = '{!! route('items.search') !!}';

			$.post(
				target_url,
				obj,
				function (data){
					$('#products-list').html(data);
				},
				'html'
			);
		});


		$('.select_item').on('click', function(event) {
			event.preventDefault();

			var item_id = $(this).data('id');
			var obj = {
				'_token': '{{ csrf_token() }}',
				'item_id': item_id,
				'parent_id': {{ $slider_id }}
			};

			var target_url = '{!! route('slides.store', $slider_id) !!}';

			$.post(
				target_url,
				obj,
				function (data){
					console.log(data);
					if(data.result == true)
					{
						var target_url = '{{ url('/'.LaravelLocalization::getCurrentLocale().'/manage/slides/view') }}' + '/' + data.slide_id;
						window.location.replace(target_url);
					} else if(data.result == false)
					{
						alert('error occurred .. please try again');
					}

				}
				
			);
		});

	});
</script>

@endsection