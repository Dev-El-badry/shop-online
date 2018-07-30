@extends('layouts.manage')

@section('content')

<h1 class="manage_title">
<i class="fa fa-gear"></i>
{{ trans('slider.slider_manage') }}
</h1>



<a class="btn btn-primary add-item"  href="{{ route('sliders.create') }}">
	<i class="fa fa-plus"></i>
	{{ trans('slider.add_slider') }}
</a>

{{-- Show Message Success --}}
@if (Session::has('item'))
    <div class="alert alert-danger">
        {{ session('item') }}
    </div>
@endif


<p>{{ $sliders->links() }}</p>
<div class="row">
	<div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #f00">{{ trans('slider.slider_manage') }}</h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">

			<!-- Start Table -->

				<table class="table">
					<thead>
						<tr>
						<th>{{ trans('blog.id') }}</th>
							<th>{{ trans('slider.slider_title') }}</th>


							<th></th>
						</tr>
					</thead>

					<tbody>

						@forelse($sliders as $row)
							<tr>
							<td>{{ $row->id }}</td>
								<td>
									 {{ $row->slider_title }}
								</td>





								<td class="pull-right">

									<?php

										if($row->status == 1) {
											echo '<a href="'.route('sliders.make_it_only_active', $row->id).'" class="btn btn-danger" onClick="preventDefault();">'.trans('items.inactive') .'</a>';
										} else {
											echo '<a href="'.route('sliders.make_it_only_active', $row->id).'" class="btn btn-success">'.trans('items.active') .'</a>';
										}
									?>

									<a href="{{ route('sliders.edit', $row->id) }}" class="btn btn-default">
									<i class="fa fa-edit fa-fw"></i> &nbsp;
									{{ trans('items.edit') }}</a>
								</td>
							</tr>

						@empty
						<tr>
							<td>
							<p style="color: red;">{{ trans('slider.alert_empty') }}</p>
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
<p>{{ $sliders->links() }}</p>

@endsection
