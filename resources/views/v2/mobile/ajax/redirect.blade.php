@if( isset($redirect_to) && !empty($redirect_to) && filter_var($redirect_to,FILTER_VALIDATE_URL) )
    <script>
        window.location.href = '{!! $redirect_to !!}';
    </script>
@endif