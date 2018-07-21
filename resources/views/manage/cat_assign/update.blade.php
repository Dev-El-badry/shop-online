@extends('layouts.manage')

@section('styles')
<style>
	.options {
	    padding: 5px 10px;
    width: 656px;
    margin-left: -126px;
	}

	#select-options
	{
		margin-bottom: 70px;
	}

</style>
@endsection

@section('content')

{{-- Start Section Add Category --}}
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-gear"></i> &nbsp;{{ trans('cat_assign.update_item_category') }}</h3>
  </div><!-- /.box-header -->
 	
 	@if($errors->any())
    <div class="error-msg">
      @foreach($errors->all() as $error)
        <p style="color: red">{{ $error }}</p>
      @endforeach
    </div>
    @endif

    @if (Session::has('item'))
	    <div class="alert alert-success">
	        {{ session('item') }}
	    </div>
	@endif


  	<form action="{{ route('store_item_category', $update_id) }}" method="POST">
  	{{ csrf_field() }}
    <div class="box-body">

	<div class="col-md-12">
	<div class="form-group" id="select-options">
		<label for="cat_id" class="col-sm-4">{{ trans('categories.category_parent') }}: </label>
	    	{!! Form::select('cat_id', $options, '', ['class'=>' col-sm-8 options', 'id'=> 'cat_id']) !!}
	    </div>
	</div>


    </div><!-- /.box-body -->

    <div class="box-footer text-center">
        <button type="submit" class="btn btn-primary" name="submit" value="Submit">{{ trans('cat_assign.submit') }}</button>

      <button type="submit" class="btn btn-bg btn-danger" name="submit" value="Finished">{{ trans('cat_assign.finished') }}</button>
    </div>
    </form>

</div>
@php
	use App\Http\Controllers\CategoryController;
@endphp
@if($num_rows >0)
<div class="row">
	<div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #f00">{{ trans('cat_assign.update_item_category') }}</h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
			
			<!-- Start Table -->
				
				<table class="table">
					<thead>
						<tr>
							<th>{{ trans('items.count') }}</th>
							
							<th>{{ trans('cat_assign.cat_name') }}</th>
							

							<th></th>
						</tr>
					</thead>

					<tbody>
						
					
					
					@foreach($cats_assign as $key=>$row)
					<tr>
						
					<td>{{ ++$key }}</td>

					
					<td>
						<span >
						{{ CategoryController::get_cat_title($row->cat_id) }}
						</span>
					</td>
					
					<td class="pull-right">
						<a href="#" class="btn btn-danger delete_cat_assign" data-id="{{ $row->id }}">
					    <i class="fa fa-trash"></i> &nbsp;
					    {{ trans('cat_assign.delet_cat_assign') }}</a>
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
	$('.delete_cat_assign').on('click', function() {
		if(confirm('{{ trans('cat_assign.alert_del') }}')){
			var cat_assign_id = $(this).data('id');

			var obj = { "_token": '{{ csrf_token() }}', "cat_assign_id": cat_assign_id };
			var target_url = "{{ route('del_cat_assign') }}";
			$.post(
				target_url,
				obj,
				function (data){
					if(data == 1)
					{
						window.location.reload();
					} else{
						alert('error occured .. please try again');
					}
				}
			);
		}
	});
</script>

@endsection