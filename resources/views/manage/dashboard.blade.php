@extends('layouts.manage')

@section('content')

<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="ion ion-ios-pricetags-outline"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">{{ trans('items.items') }}</span>
          <span class="info-box-number">{{ $items_count }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">{{ trans('user.users') }}</span>
          <span class="info-box-number">{{ $user_count }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>

      <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-blue"><i class="ion-ios-chatbubble-outline"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">{{ trans('enquiries.messages') }}</span>
          <span class="info-box-number">{{ $enquireies_count }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
</div>

<div class="row">
<div class="col-md-8 col-sm-12">
		<div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">{{ trans('items.latest_products') }}</h3>


    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="table-responsive">
        <table class="table no-margin">
          <thead>
          <tr>
            <th>{{ trans('blog.id') }}</th>
            <th>{{ trans('items.title') }}</th>
            <th>{{ trans('items.status') }}</th>
            <th>{{ trans('items.price') }}</th>
          </tr>
          </thead>
          <tbody>
          @forelse($items as $item)
          <tr>
            <td><a href="pages/examples/invoice.html">{{ $item->id }}</a></td>
            <td>{{ unserialize($item->item_title)[LaravelLocalization::getCurrentLocale()] }}</td>
            <td><span class="">
            	@php
            		if($item->status == 0)
            			echo '<small class="label label-primary">'.trans('items.active').'</small>';
            		else
            			echo '<small class="label label-danger">'.trans('items.inactive').'</small>';
            	@endphp
            </span></td>
            <td>
              <small class="label label-success">{{ $item->item_price }} {!! $currencySymbol !!}</small>
            </td>
          </tr>
          @empty
			<p>{{ trans('items.empty') }}</p>
          @endforelse
          
          </tbody>
        </table>
      </div>
      <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
      <a href="{{ route('items.create') }}" class="btn btn-sm btn-info btn-flat pull-left">{{ trans('items.add_new_product') }}</a>
      <a href="{{ route('items.index') }}" class="btn btn-sm btn-default btn-flat pull-right">{{ trans('items.view_all_prods') }}</a>
    </div>
    <!-- /.box-footer -->
  </div>
</div> <!-- End Products -->

{{-- Start Users --}}

<div class="col-md-4">
  <!-- USERS LIST -->
  <div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title">{{ trans('user.latest_members') }}</h3>

      <div class="box-tools pull-right">
        <span class="label label-danger">
        @php
        	if($user_count >8)
        	{
        		echo '8';
        	} else {
        		echo $user_count;
        	}
        @endphp
        {{ trans('user.label') }}</span>
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
        </button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
      <ul class="users-list clearfix">
      @forelse($users as $user)
        <li>
          <img src="{{ asset('user_pics/'.$user->picture.'') }}" alt="User Image">
          <a class="users-list-name" href="#">{{ $user->name }}</a>
          <span class="users-list-date">{{ $user->create_at }}</span>
        </li>
       @empty
		<p style="color: red;padding: 10px 5px">{{ trans('user.empty') }}</p>
       @endforelse

      </ul>
      <!-- /.users-list -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer text-center">
      <a href="{{ route('users.index') }}" class="uppercase">{{ trans('user.view_all_users') }}</a>
    </div>
    <!-- /.box-footer -->
  </div>
  <!--/.box -->
</div>


{{-- End Users --}}

</div>


{{-- Start Messages --}}

<div class="row">
	<div class="col-md-8 col-sm-12">
	<div class="box box-primary">
   <div class="box-header with-border">
      <h3 class="box-title">{{ trans('enquiries.new_message') }}</h3>


    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="table-responsive">
        <table class="table no-margin">
          <thead>
          <tr>
            <th>{{ trans('enquiries.code') }}</th>
            <th>{{ trans('enquiries.subject') }}</th>
            <th>{{ trans('enquiries.status') }}</th>
            <th>{{ trans('enquiries.sent_by') }}</th>
          </tr>
          </thead>
          <tbody>
          @forelse($enquiries as $row)
          <tr>
            <td>{{ $row->code }}</td>
            <td>{{ $row->subject }}</td>
            <td><span class="">
            	@php
            		if($row->opened == 0)
            			echo '<small class="label label-primary">'.trans('enquiries.unread').'</small>';
            		else
            			echo '<small class="label label-danger">'.trans('enquiries.read').'</small>';
            	@endphp
            </span></td>
            <td>
              <div class="sparkbar" data-color="#00a65a" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
            </td>
          </tr>
          @empty
          <tr><td>
			<p style="color: red;padding: 10px 5px">{{ trans('enquiries.alert_empty') }}</p>
			</td></tr>
          @endforelse
          
          </tbody>
        </table>
      </div>
      <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
      
      <a href="{{ route('items.index') }}" class="btn btn-sm btn-default btn-flat pull-right">{{ trans('enquiries.view_all_msgs') }}</a>
    </div>
    <!-- /.box-footer -->
  </div>
</div> <!-- End Products -->
</div>
{{-- End Messages --}}

@endsection
