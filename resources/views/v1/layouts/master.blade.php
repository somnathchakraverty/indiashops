@if ( !isset($ajax) )
	@include('v1.common.header')
@endif
@yield('content')
@if ( !isset($ajax) )
	<script type="text/javascript">
		var base_url 	= '{{url("/")}}';
		var img_url 	= '{{url("/images")}}';
		var alvendors 	= <?=json_encode( config("vendor") ) ?>;
		var composer_url= '<?=composer_url("")?>';
	</script>
	@include('v1.common.footer')
	@yield('script')
@endif