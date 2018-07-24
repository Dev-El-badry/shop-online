@extends('layouts.manage')

@section('content')

<h1 class="manage_title">
<i class="fa fa-users"></i>
{{ trans('user.view_user') }} <small>{{ $user->name }}</small>
</h1>


{{-- start seection to show image --}}
<div class="row">
	<div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #f00">{{ trans('items.options') }}</h3>
			
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        	<a href="{{ route("users.delete_config", $user->id) }}" class="btn btn-danger">
        		<i class="fa fa-trash"></i> &nbsp; {{ trans('user.del') }}
        	</a>
        </div>
      </div>
    </div>
</div>
{{-- end section image --}}


@if($user->picture != null)
{{-- start seection to show image --}}
<div class="row">
	<div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #f00">{{ trans('user.view_user') }}</h3>
			
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
        <img src="{{ asset('users_pics/'.$user->picture) }}" alt="">
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
          <h3 class="box-title" style="color: #f00">{{ trans('user.view_user') }}</h3>
			
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
			
			<!-- Start Table -->
				
				<table class="table">
					<thead>
						<tr>
							<th>{{ trans('blog.id') }}</th>
							<td>{{ $user->id }}</td>
						</tr>
						<tr>
							<th>{{ trans('user.username') }}</th>
							<td>{{ $user->name != null ? $user->name : '-' }}</td>
						</tr>
						<tr>
							<th>{{ trans('user.email') }}</th>
							<td>{{ $user->email != null ? $user->email : '-'  }}</td>
						</tr>
						<tr>
							<th>{{ trans('user.phone_number') }}</th>
							<td>{{ $user->phone_number != null ? $user->phone_number : '-'  }}</td>
						</tr>
						<tr>
							<th>{{ trans('user.firstname') }}</th>
							<td>{{ $user->firstname != null ? $user->firstname : '-'  }}</td>
						</tr>
						<tr>
							<th>{{ trans('user.lastname') }}</th>
							<td>{{ $user->lastname != null ? $user->lastname : '-'  }}</td>
						</tr>
						<tr>
							<th>{{ trans('user.address1') }}</th>
							<td>{{ $user->address1 != null ? $user->address1 : '-'  }}</td>
						</tr>
						<tr>
							<th>{{ trans('user.address2') }}</th>
							<td>{{ $user->address2 != null ? $user->address2 : '-'  }}</td>
						</tr>
						<tr>
							<th>{{ trans('user.country') }}</th>
							<td>{{ $user->country != null ? $user->country : '-'  }}</td>
						</tr>
						<tr>
							<th>{{ trans('user.town') }}</th>
							<td>{{ $user->town != null ? $user->town : '-'  }}</td>
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