@extends('layouts.manage')

@section('content')

<h1 class="manage_title">
<i class="fa fa-users"></i>
{{ trans('user.manage_title') }}
</h1>




{{-- Show Message Success --}}
@if (Session::has('item'))
    <div class="alert alert-danger">
        {{ session('item') }}
    </div>
@endif
@if($users_count <=0)
<p style="color: red">{{ trans('user.empty') }}</p>
@else

<p>{{ $users->links() }}</p>
<div class="row">
	<div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #f00">{{ trans('user.manage_title') }}</h3>
			
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
							<th>{{ trans('blog.id') }}</th>
							<th>{{ trans('user.username') }}</th>
							<th>{{ trans('user.email') }}</th>
							<th>{{ trans('user.phone_number') }}</th>
							<th>{{ trans('user.firstname') }}</th>
							<th>{{ trans('user.lastname') }}</th>
							<th>{{ trans('user.address1') }}</th>
							<th>{{ trans('user.address2') }}</th>
							<th>{{ trans('user.country') }}</th>
							<th>{{ trans('user.town') }}</th>
							<th>{{ trans('user.verified') }}</th>
							<th></th>
						</tr>
					</thead>

					<tbody>

						@forelse($users as $row)
							<tr>
								<td>{{ $row->id }}</td>

								<td>{{ $row->name }}</td>
								<td>{{ $row->email }}</td>
								<td>{{ $row->phone_number != null ? $row->phone_number : '-' }}</td>
								<td>{{ $row->firstname != null ? $row->firstname : '-' }}</td>
								<td>{{ $row->lastname != null ? $row->lastname : '-' }}</td>
								<td>{{ $row->address1 != null ? $row->address1 : '-' }}</td>
								<td>{{ $row->address2 != null ? $row->address2 : '-' }}</td>
								<td>{{ $row->country != null ? $row->country : '-' }}</td>
								<td>{{ $row->town != null ? $row->town : '-' }}</td>
								
								<td>
									@php
										if(!$row->is_verified) {
											echo '<span class="label label-danger">'.trans('user.inactivation').'</span>';
										} else {
											echo '<span class="label label-success">'.trans('user.activation').'</span>';
										}
									@endphp
								</td>

								<td class="pull-right">
							
									<a title="view user" href="{{ route('users.view', $row->id) }}" class="btn btn-default">
									<i class="fa  fa-external-link fa-fw"></i></a>

									
								</td>
							</tr>

						@empty
						<tr>
							<td>
							<p style="color: red;">{{ trans('blog.alert_empty') }}</p>
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

<p>{{ $users->links() }}</p>
@endif
@endsection