@extends('layouts.manage')



@section('content')

<h1 class="manage_title">
<i class="fa fa-gear"></i>
{{ trans('categories.manage_title') }}
</h1>
<a class="btn btn-primary add-item"  href="{{ route('category.create') }}">
	<i class="fa fa-plus"></i>
	{{ trans('categories.add_category') }}
</a>

<div class="row">
	<div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="color: #f00">{{ trans('categories.box_title') }}</h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body">

			<?php
			use App\Http\Controllers\CategoryController;
			echo CategoryController::get_sortable_list($data['row_id'], $data['status']); 
			?>

        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
</div>


@endsection

@php
	// $first_bit = Request::segment(1);
	$third_bit = Request::segment(2);
	$first_bit = 'category';

	$full_url = url('manage').'/' . $first_bit . '/sort';


	if($third_bit != '')
	{
		$start_of_target_url = '../../';
	} else {
		$start_of_target_url = '../';
	}

@endphp

@section('scripts')

<script type="text/javascript">
    $(document).ready(function(){
        $( "#sortlist" ).sortable({
            stop: function(event, ui) {saveChanges();}
        });
        $( "#sortlist" ).disableSelection();
		
		function saveChanges() {
		//length of elments
			var num = $('#sortlist > li').length;
			console.log('number'+num);
			var arr = [];
			for (var i = 1; i <= num; i++) {
				var catID = $('#sortlist li:nth-child('+i+')').attr('id');
				arr.push(catID)
			}

			console.log(arr);
			console.log(arr.join());
			var arrJoin = arr.join();
			var obj = { "num": num, "order": arrJoin, "_token": '{{ csrf_token() }}' };
			console.log(obj);

			$.post(
				'{{ $full_url }}',
				obj,
				function(data) {
					console.log('well done')
				}
			);
		}

		
	
	}); 

	function saveChanges() {
		//length of elments
			var num = $('#sortlist > li').length;
			console.log('number'+num);
			var arr = [];
			for (var i = 1; i <= num; i++) {
				var catID = $('#sortlist li:nth-child('+i+')').attr('id');
				arr.push(catID)
			}

			console.log(arr);
		}
</script>
@endsection