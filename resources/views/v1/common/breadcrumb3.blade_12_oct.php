@if ($breadcrumbs)
	<ol class="breadcrumb" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
		@foreach ($breadcrumbs as $breadcrumb)
			@if ($breadcrumb->url && !$breadcrumb->last)
				<li><a href="{{{ $breadcrumb->url }}}" itemprop="url">
					<span itemprop="title">{{{ $breadcrumb->title }}}</span>
				</a></li>
			@else
				<li class="active"><span itemprop="title">{{{ $breadcrumb->title }}}</span></li>
			@endif
		@endforeach
	</ol>
@endif
