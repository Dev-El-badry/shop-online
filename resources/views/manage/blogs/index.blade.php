@extends('layouts.manage')

@section('content')

<h1 class="manage_title">
<i class="fa fa-gear"></i>
{{ trans('blog.manage_title') }}
</h1>



<a class="btn btn-primary add-item"  href="{{ route('blogs.create') }}">
	<i class="fa fa-plus"></i>
	{{ trans('blog.add_blog') }}
</a>

{{-- Show Message Success --}}
@if (Session::has('item'))
    <div class="alert alert-danger">
        {{ session('item') }}
    </div>
@endif


<p>{{ $blogs->links() }}</p>
<div class="row">
	<div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #f00">{{ trans('blog.manage_title') }}</h3>
			
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
							<th>{{ trans('blog.image') }}</th>
							<th>{{ trans('blog.title') }}</th>
							<th>{{ trans('blog.blog_url') }}</th>
							<th>{{ trans('blog.content') }}</th>
							<th>{{ trans('items.status') }}</th>
							<th></th>
						</tr>
					</thead>

					<tbody>

						@forelse($blogs as $row)
							<tr>
							<td>{{ $row->id }}</td>
								<td>
									
									 <img src="{{ asset('blog_pics/'.str_replace('.', '-thubmnail.', $row->picture)) }}" class="img-responsive img-thumbnaill">
								</td>
								<td>{{ unserialize($row->blog_title)[LaravelLocalization::getCurrentLocale()] }}</td>
								<td>/{{ $row->blog_url }} </td>
								
								
								<td>{!!  unserialize($row->blog_content)[LaravelLocalization::getCurrentLocale()] !!}</td>
								@if($row->status == 1)
								<td><span class="label label-success">{{ trans('blog.publish') }}</span></td>
								@else
								<td><span class="label label-warning">{{ trans('blog.save_darft') }}</span></td>
								@endif
								<td class="pull-right">
							
									<a href="{{ route('blogs.edit', $row->id) }}" class="btn btn-default">
									<i class="fa fa-edit fa-fw"></i> &nbsp;
									{{ trans('items.edit') }}</a>

									
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
<p>{{ $blogs->links() }}</p>

@endsection