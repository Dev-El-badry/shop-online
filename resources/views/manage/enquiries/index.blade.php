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
@if($enquiries_count <=0)
<p style="color: red">{{ trans('user.empty') }}</p>
@else

<p>{{ $enquiries->links() }}</p>
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
							<th></th>
							
							<th>{{ trans('enquiries.code') }}</th>
							<th>{{ trans('enquiries.subject') }}</th>
							<th>{{ trans('enquiries.sent_to') }}</th>
							<th>{{ trans('enquiries.sent_by') }}</th>
							<th></th>
						</tr>
					</thead>

					<tbody>

						@forelse($enquiries as $row)
						
							<tr style="color: {{ $row->urgent == 1 ? 'red' : '' }}">
							@if($row->opened == 0)
							<td style="color: orange" class="text-center"><i class="fa fa-envelope fa-fw"></i></td>
							@else
							<td class="text-center"><i class="fa fa-envelope-o fa-fw"></i></td>
							@endif
								

								<td>{{ $row->code }}</td>
								<td>{{ $row->subject }}</td>
								<td>{{ $row->sent_to == 0 ? 'Admin' : $row->sent_to}}</td>
								<td><a href="{{ route('users.view', $row->sent_by) }}">{{ $row->sent_by}}</a></td>
								
								<td class="pull-right">
							
									<a title="view user" href="{{ route('enquiries.view', $row->id) }}" class="btn btn-default">
									<i class="fa  fa-eye fa-fw"></i></a>

									
								</td>
							</tr>

						@empty
						<tr>
							<td>
							<p style="color: red;">{{ trans('enquiries.alert_empty') }}</p>
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

<p>{{ $enquiries->links() }}</p>
@endif
@endsection