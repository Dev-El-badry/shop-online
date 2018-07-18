@extends('layouts.manage')

@section('content')

<h1 class="manage_title">
<i class="fa fa-gear"></i>
{{ trans('items.manage_title') }}
</h1>
<a class="btn btn-primary add-item"  href="{{ route('items.create') }}">
	<i class="fa fa-plus"></i>
	{{ trans('main.add_item') }}
</a>

<div class="row">
	<div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #f00">{{ trans('items.box_title') }}</h3>
			
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
							<th>{{ trans('items.title') }}</th>
							<th>{{ trans('items.price') }}</th>
							<th>{{ trans('items.was_price') }}</th>
							<th>{{ trans('items.status') }}</th>
							<th>{{ trans('items.description') }}</th>
							<th></th>
						</tr>
					</thead>

					<tbody>

						@forelse($items as $row)
							<tr>
								<td>{{ unserialize($row->item_title)[LaravelLocalization::getCurrentLocale()] }}</td>
								<td>{{ $row->item_price }} {!! $currencySymbol !!}</td>
								<td>{{ $row->was_price }} {!! $currencySymbol !!}</td>
								<td>{!! $row->status == 1 ? '<small class="label label-primary">'.trans('items.active') .'</label>' : '<small class="label label-danger">'.trans('items.inactive').'</label>' !!}</td>
								<td>{!!  unserialize($row->item_description)[LaravelLocalization::getCurrentLocale()] !!}</td>
								<td class="pull-right">
									<a href="{{ route('items.show', $row->id) }}" class="btn btn-default">
									<i class="fa fa-eye fa-fw"></i> &nbsp;
									{{ trans('items.show') }}</a>
									<a href="{{ route('items.edit', $row->id) }}" class="btn btn-default">
									<i class="fa fa-edit fa-fw"></i> &nbsp;
									{{ trans('items.edit') }}</a>
								</td>
							</tr>

						@empty
						<tr>
							<td>
							<p style="color: red;">There Not Found Items In Database</p>
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


@endsection