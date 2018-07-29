@extends('layouts.manage')

@section('content')

<h1 class="manage_title">
<i class="fa fa-users"></i>
{{ trans('admins.view_admin') }} <small>{{ $admin->name }}</small>
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
        	<a href="{{ route("admins.update", $admin->id) }}" class="btn btn-primary">
        		<i class="fa fa-trash"></i> &nbsp; {{ trans('admins.update') }}
        	</a>
        </div>
      </div>
    </div>
</div>
{{-- end section image --}}


<div class="row">
	<div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #f00">{{ trans('admins.view_admin') }}</h3>
			
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
			
			<!-- Start Table -->
				
				<table class="table">
					<thead>
						<tr>
							<th>{{ trans('blog.id') }}</th>
							<td>{{ $admin->id }}</td>
						</tr>
						<tr>
							<th>{{ trans('admins.name') }}</th>
							<td>{{ $admin->name != null ? $admin->name : '-' }}</td>
						</tr>
						<tr>
							<th>{{ trans('admins.email') }}</th>
							<td>{{ $admin->email != null ? $admin->email : '-'  }}</td>
						</tr>
					
						<tr>
							<th>{{ trans('admins.job_title') }}</th>
							<td>{{ $admin->job_title != null ? $admin->job_title : '-'  }}</td>
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