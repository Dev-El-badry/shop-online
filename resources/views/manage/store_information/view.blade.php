@extends('layouts.manage')

@section('styles')
<style>
	th{
		width: 200px
	}
</style>
@endsection

@section('content')

<h1 class="manage_title">
<i class="fa fa-users"></i>
{{ trans('store_info.view_store') }} <small>{{ unserialize($info->store_title)[LaravelLocalization::getCurrentLocale()] }}</small>
</h1>





@if($info->picture != null)
{{-- start seection to show image --}}
<div class="row">
	<div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #f00">{{ trans('store_info.view_store') }}</h3>
			
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
        <img src="{{ asset('store_pics/'.$info->picture) }}" alt="">
        </div>
      </div>
    </div>
</div>
{{-- end section image --}}
@endif


<div class="row">
	<div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #f00">{{ trans('store_info.view_store') }}</h3>
			
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
			
			<!-- Start Table -->
				
				<table class="table">
					<thead>
						<tr>
							<th>{{ trans('blog.id') }}</th>
							<td>{{ $info->id }}</td>
						</tr>

						@foreach(LaravelLocalization::getSupportedLocales() as $key=>$value)
						<tr>
							<th>{{ trans('store_info.title') }} ({{ $value['native'] }})</th>
							<td>{{ unserialize($info->store_title)[$key] }}</td>
						</tr>
						@endforeach

						@foreach(LaravelLocalization::getSupportedLocales() as $key=>$value)
						<tr>
							<th>{{ trans('store_info.description') }} ({{ $value['native'] }})</th>
							<td
								style="
								background-color: #ccc;
								padding: 20px 8px;
								font-size: 14px
								">{!!  unserialize($info->description)[$key] !!}</td>
						</tr>
						@endforeach
						

						<tr>
							<th>{{ trans('store_info.email') }}</th>
							<td>{{ $info->email != null ? $info->email : '-'  }}</td>
						</tr>
						<tr>
							<th>{{ trans('store_inf.phone_number') }}</th>
							<td>{{ $info->phone_number != null ? $info->phone_number : '-'  }}</td>
						</tr>
					
						<tr>
							<th>{{ trans('store_info.address1') }}</th>
							<td>{{ $info->address1 != null ? $info->address1 : '-'  }}</td>
						</tr>
						<tr>
							<th>{{ trans('store_info.address2') }}</th>
							<td>{{ $info->address2 != null ? $info->address2 : '-'  }}</td>
						</tr>
						<tr>
							<th>{{ trans('store_info.country') }}</th>
							<td>{{ $info->country != null ? $info->country : '-'  }}</td>
						</tr>
						<tr>
							<th>{{ trans('store_info.town') }}</th>
							<td>{{ $info->town != null ? $info->town : '-'  }}</td>
						</tr>

						<tr>
							<th>{{ trans('store_info.latitude') }}</th>
							<td>{{ $info->latitude != null ? $info->latitude : '-'  }}</td>
						</tr>

						<tr>
							<th>{{ trans('store_info.longitude') }}</th>
							<td>{{ $info->longitude != null ? $info->longitude : '-'  }}</td>
						</tr>

					</thead>


				</table>


			<!-- End Table -->

        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
</div>


@endsection