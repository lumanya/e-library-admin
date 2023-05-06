<script type="text/javascript">

    @if(Session::has('success'))
        Snackbar.show({text: '{{ Session::get('success') }}', pos: 'bottom-center'});
    @endif

    @if(isset($errors) && $errors->any())
        Snackbar.show({text: '{{ $errors->first() }}', pos: 'bottom-center'});
    @endif

</script>