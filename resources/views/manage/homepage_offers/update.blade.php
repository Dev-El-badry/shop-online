@extends('layouts.manage')

@section('content')

{{-- Start Section Update Color --}}
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-gear"></i> &nbsp;{{ trans('blocks.new_offer') }}</h3>
  </div><!-- /.box-header -->
 	
 	@if($errors->any())
    <div class="error-msg">
      @foreach($errors->all() as $error)
        <p style="color: red">{{ $error }}</p>
      @endforeach
    </div>
    @endif


  	<form action="{{ route('homepage_offers.store', $update_id) }}" method="POST">
  	{{ csrf_field() }}
    <div class="box-body">
		<p style="color: green">{{ trans('blocks.msg_offer') }}</p>
		
		<div class="col-md-6 col-sm-12">
			<div class="form-group">
				<label for="new_offer" class="col-sm-4">{{ trans('blocks.new_offer') }}</label>
				<div class="col-md-8">
					<input type="text" class="form-control" id="new_offer" name="item_id" dir="auto">
					<div id="list-products"></div>
				</div>
			</div>
		
		
		</div>
    </div><!-- /.box-body -->

    <div class="box-footer text-center">
        <button type="submit" class="btn btn-success" name="submit" value="Finished">{{ trans('items.finished') }}</button>

      <button type="submit" class="btn btn-bg btn-primary" name="submit" value="Submit">{{ trans('blocks.add_offer') }}</button>
    </div>
    </form>

</div>

{{-- Show Message Success --}}
@if (Session::has('item'))
    <div class="alert alert-success">
        {{ session('item') }}
    </div>
@endif

@if (Session::has('item_del'))
    <div class="alert alert-danger">
        {{ session('item_del') }}
    </div>
@endif

{{-- Start Section Manage Item Colors--}}
@if($num_rows >0)
<div class="row">
	<div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #f00">{{ trans('blocks.new_offers') }}</h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
			
			<!-- Start Table -->
				
				<table class="table">
					<thead>
						<tr>
							<th>{{ trans('items.count') }}</th>
							
							<th>{{ trans('blocks.item') }}</th>
							

							<th></th>
						</tr>
					</thead>

					<tbody>
						
					
					
					@foreach($data as $key=>$value)
					<tr>
						
					<td>{{ ++$key }}</td>

					<td>
						<h4 >
						{{ unserialize($value->items->item_title)[LaravelLocalization::getCurrentLocale()] }}
						</h4>
					</td>
					
					<td class="pull-right">
						<a href="#" class="btn btn-danger delete_offer" data-id="{{ $value->id }}">
					    <i class="fa fa-trash"></i> &nbsp;
					    {{ trans('blocks.delete_offer') }}</a>
					</td>
					</tr>
					@endforeach

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
	$('.delete_offer').on('click', function(event) {
		event.preventDefault();
		var id = $(this).data('id');
		var target_url = '{{ route('homepage_offers.delete') }}';

		var obj = {
			"_token": '{{ csrf_token() }}',
			'id': id
		};

		$.post(
			target_url,
			obj,
			function(data)
			{
				if(data == 1)
					location.reload();
				else
					alert('error occured .. try again!');
			}
		);

	});


</script>
@endsection