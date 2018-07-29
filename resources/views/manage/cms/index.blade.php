@extends('layouts.manage')

@section('content')

<h1 class="manage_title">
<i class="fa fa-gear"></i>
{{ trans('cms.manage_title') }}
</h1>



<a class="btn btn-primary add-item"  href="{{ route('web_pages.create') }}">
	<i class="fa fa-plus"></i>
	{{ trans('cms.add_cms') }}
</a>

{{-- Show Message Success --}}
@if (Session::has('item'))
    <div class="alert alert-danger">
        {{ session('item') }}
    </div>
@endif


<p>{{ $webpages->links() }}</p>
<div class="row">
	<div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #f00">{{ trans('cms.manage_title') }}</h3>
			
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
							<th>{{ trans('cms.title') }}</th>
							<th>{{ trans('cms.item_url') }}</th>
							<th>{{ trans('cms.content') }}</th>
							<th></th>
						</tr>
					</thead>

					<tbody>

						@forelse($webpages as $row)
							<tr>
							<td>{{ $row->id }}</td>
								<td>{{ unserialize($row->page_title)[LaravelLocalization::getCurrentLocale()] }}</td>
								<td>/{{ $row->page_url }} </td>
								
								
								<td>{!!  unserialize($row->page_content)[LaravelLocalization::getCurrentLocale()] !!}</td>
								<td class="pull-right">
							
									<a href="{{ route('web_pages.edit', $row->id) }}" class="btn btn-default">
									<i class="fa fa-edit fa-fw"></i> &nbsp;
									{{ trans('items.edit') }}</a>
								</td>
							</tr>

						@empty
						<tr>
							<td>
							<p style="color: red;">{{ trans('items.empty') }}</p>
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
<p>{{ $webpages->links() }}</p>

@endsection