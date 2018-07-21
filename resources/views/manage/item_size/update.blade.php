@extends('layouts.manage')

@section('content')

{{-- Start Section Update size --}}
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-gear"></i> &nbsp;{{ trans('items.new_size_option') }}</h3>
  </div><!-- /.box-header -->
 	
 	@if($errors->any())
    <div class="error-msg">
      @foreach($errors->all() as $error)
        <p style="size: red">{{ $error }}</p>
      @endforeach
    </div>
    @endif


  	<form action="{{ route('store_size', $data['update_id']) }}" method="POST">
  	{{ csrf_field() }}
    <div class="box-body">

	@foreach(LaravelLocalization::getSupportedLocales() as $key=>$value)
	<div class="col-md-6 col-sm-12">
		<div class="form-group">
			<label for="size_{{ $key }}" class="col-sm-4">{{ trans('items.option_ar') }} {{ $value['native'] }}</label>
			<div class="col-md-8">
				<input type="text" class="form-control" id="size_{{ $key }}" name="size[{{ $key }}]" dir="auto">
			</div>
		</div>
	</div>
	@endforeach

    </div><!-- /.box-body -->

    <div class="box-footer text-center">
        <button type="submit" class="btn btn-success" name="submit" value="Finished">{{ trans('items.finished') }}</button>

      <button type="submit" class="btn btn-bg btn-primary" name="submit" value="Submit">{{ trans('items.add_size') }}</button>
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

{{-- Start Section Manage Item sizes--}}
@if($data['num_rows'] >0)
<div class="row">
	<div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="size: #f00">{{ trans('items.size_title') }}</h3>
			
          <div class="box-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
              
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
			
			<!-- Start Table -->
				
				<table class="table">
					<thead>
						<tr>
							<th>{{ trans('items.count') }}</th>
							@foreach(LaravelLocalization::getSupportedLocales() as $key=>$value)
							<th>{{ trans('items.size_option_in') }} {{ $value['native'] }}</th>
							@endforeach

							<th></th>
						</tr>
					</thead>

					<tbody>
						
					
					
					@foreach($data['sizes'] as $k=> $v)
					<tr>
						
					<td>{{ ++$k }}</td>

					@foreach(LaravelLocalization::getSupportedLocales() as $key=>$value)
					<td>
						<span >
						{{ unserialize($v->size)[$key] }}
						</span>
					</td>
					@endforeach
					<td class="pull-right">
						<a href="#" class="btn btn-danger delete_size" data-id="{{ $v->id }}">
					    <i class="fa fa-trash"></i> &nbsp;
					    {{ trans('items.delete_size') }}</a>
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
	$('.delete_size').on('click', function(event) {
		event.preventDefault();
		var id = $(this).data('id');
		var target_url = '{{ route('delete_size') }}';

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