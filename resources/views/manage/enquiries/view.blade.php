@extends('layouts.manage')



@section('content')

<h1 class="manage_title">
<i class="fa fa-users"></i>
{{ trans('enquiries.view') }} <small>{{ $enquiry->code }}</small>
</h1>


<a class="btn btn-default" style="margin: 10px auto" href="{{ route('enquiries.index') }}" >{{ trans('categories.pervious_page') }}</a>



{{-- start seection to show image --}}
<div class="row">
	<div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #f00">{{ trans('enquiries.ranking') }}</h3>
			
        </div>
        <!-- /.box-header -->
		<form action="{{ route('enquiries.submitted_ranking', $enquiry->id) }}" method="POSt">
			{{ csrf_field() }}
			<div class="box-body table-responsive">
				<div class="form-group">
					<label for="ranking" class=" col-md-2">{{ trans('enquiries.ranking') }}:</label>
					<div class="col-md-10">
					{!! Form::select('ranking', $options, $enquiry->ranking, ['class'=>'form-control', 'id'=> 'ranking']) !!}
					</div>
				</div>
			</div>
			<div class="box-footer">
				<button class="btn btn-primary" type="submit" name="submit" value="Submit">{{ trans('enquiries.submit') }}</button>
			</div>
		</form>
      </div>
    </div>
</div>
{{-- end section image --}}

{{-- Show Message Success --}}
@if (Session::has('item'))
    <div class="alert alert-success">
        {{ session('item') }}
    </div>
@endif


<div class="row">
	<div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #f00">{{ trans('enquiries.view') }}</h3>
			
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
			
			<!-- Start Table -->
				
				<table class="table">
					<thead>
						<tr>
							<th>{{ trans('blog.id') }}</th>
							<td>{{ $enquiry->id }}</td>
						</tr>
						<tr>
							<th>{{ trans('enquiries.code') }}</th>
							<td>{{ $enquiry->code }}</td>
						</tr>
						<tr>
							<th>{{ trans('enquiries.subject') }}</th>
							<td>{{ $enquiry->subject}}</td>
						</tr>
						<tr>
							<th>{{ trans('enquiries.sent_to') }}</th>
							<td>{{ $enquiry->sent_to != 0 ? $enquiries->sent_to : 'Admin'  }}</td>
						</tr>
						<tr>
							<th>{{ trans('enquiries.sent_by') }}</th>
							<td>{{ $enquiry->sent_by != 0 ? $enquiry->sent_by : 'Admin'  }}</td>
						</tr>

						<tr>
							<th>{{ trans('enquiries.message') }}</th>
							<td
								style="
								background-color: #ccc;
								padding: 20px 8px;
								font-size: 14px
								"
							>{{ $enquiry->message}}</td>
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