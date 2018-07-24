@section('styles')
<style>
	.sort {
	    border: 1px solid #ccc;
	    list-style: none;
	    padding: 10px;
	    margin-top: 5px;
	    width: 600px
    }
</style>
@endsection

@php
	use App\Http\Controllers\HomepageBlock;
@endphp

<ul style="margin: 10px 0" id="sortlist">

@foreach($data['blocks'] as $row)

		@php
			$block_title = unserialize($row->cat_title)[LaravelLocalization::getCurrentLocale()];
		@endphp
	
	@php
		$get_count_blocks = HomepageBlock::get_count_blocks($row->id);
	@endphp
	<li class="sort" id="{{ $row->id }}">
		<i class="fa fa-sort fa-fw fa-lg"></i>&nbsp;
		@foreach(LaravelLocalization::getSupportedLocales() as $key=>$value)
		[{{ unserialize($row->block_title)[$key] }}]&nbsp;
		@endforeach

		@if($get_count_blocks ==0)
			
		@else
			@if($get_count_blocks == 1)
				@php
					$entity = 'Block';
				@endphp
			@else
				@php
					$entity = 'Blocks';
				@endphp
			@endif

		
		@endif
		
		<a href="{{ route('homepage_blocks.edit', $row->id) }}">
			<i class="fa fa-edit fa-fw"></i>
		</a>

	</li>

@endforeach

</ul>