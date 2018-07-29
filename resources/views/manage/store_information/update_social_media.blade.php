@extends('layouts.manage')

@section('styles')
<style>
	.options {
	    padding: 5px 10px;
    
   
	}

	#select-options
	{
		margin-bottom: 70px;
	}

	#list-icons {
		font-family: fontAwesome
	}

</style>
@endsection

@section('content')

{{-- Start Section Add Category --}}
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-gear"></i> &nbsp;{{ trans('store_info.update_social_media') }}</h3>
  </div><!-- /.box-header -->
 	
 	@if($errors->any())
    <div class="error-msg">
      @foreach($errors->all() as $error)
        <p style="color: red">{{ $error }}</p>
      @endforeach
    </div>
    @endif



  	<form action="{{ route('store_info.store_social_media', $update_id) }}" method="POST">
  	{{ csrf_field() }}
    <div class="box-body">

	<div class="row">
		<div class="col-md-6 col-sm-12">
			<div class="form-group">
				<label for="list-icons" class="col-sm-2">{{ trans('store_info.icons') }}: </label>
				@php
				$options = [
					''=> trans('store_info.choose'),
					'fa-facebook-square'=> '&#xf082; Facebook',
					'fa-twitter-square'=> '&#xf081; Twitter',
					'fa-instagram'=> '&#xf16d; Instagram',
					'fa-pinterest-square'=> '&#xf0d3; Pinterest',
					'fa-linkedin-square'=> '&#xf08c; Linkedin',
					'fa-google-plus-square'=> '&#xf0d4; Google',
					];
				

				@endphp

				{!! Form::select('icons', $options, '', ['class'=>'col-sm-10 options', 'id'=> 'list-icons']) !!}
		    	
		    </div>
		</div>

		<div class="col-md-6 col-sm-12">
		    <div class="form-group" >
				<label for="title" class="col-sm-2">{{ trans('store_info.title_network') }}: </label>
 				<div class="col-sm-10">
				<input type="text" class="form-control " id="title"  name="title" placeholder="{{ trans('store_info.title_placeholder') }}">
				</div>
				 <div class="col-sm-10">
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12">
			 <div class="form-group " id="select-options">
				<label for="url" class="col-sm-2">{{ trans('store_info.url') }}: </label>
				<div class="col-sm-10">
				<input type="text" class="form-control " style="width: 400px" id="url" name="url" placeholder="{{ trans('store_info.url_placeholder') }}">
				</div>	
			</div>
		</div>
	</div>



    </div><!-- /.box-body -->
    </div>

    <div class="box-footer text-center">
        <button type="submit" class="btn btn-primary" name="submit" value="Submit">{{ trans('cat_assign.submit') }}</button>

     {{--  <button type="submit" class="btn btn-bg btn-danger" name="submit" value="Finished">{{ trans('cat_assign.finished') }}</button> --}}
    </div>
    </form>

</div>
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

@if($social_networks_count >0)
<div class="row" >
	<div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #f00">{{ trans('store_info.update_social_media') }}</h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
			
			<!-- Start Table -->
				
				<table class="table">
					<thead>
						<tr>
							<th>{{ trans('items.count') }}</th>
							
							
							<th>{{ trans('store_info.title_network') }}</th>
							

							<th></th>
						</tr>
					</thead>

					<tbody>
						
					
					
					@foreach($social_networks->social_networks as $key=>$row)
					<tr>
						
					<td>{{ ++$key }}</td>

					
				

					<td>
					 <i class="fa {{ $row->icons }}"></i> &nbsp;
						{{ $row->title }}
					</td>
					
					<td class="pull-right">
						<a href="#" class="btn btn-danger delete_account" data-id="{{ $row->id }}">
					    <i class="fa fa-trash"></i> &nbsp;
					    {{ trans('store_info.delete_account') }}</a>
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
	$('.delete_account').on('click', function() {
		if(confirm('{{ trans('store_info.msg_del') }}')){
			var account_id = $(this).data('id');

			var obj = { "_token": '{{ csrf_token() }}', "account_id": account_id };
			var target_url = "{{ route('store_info.delete_account') }}";
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