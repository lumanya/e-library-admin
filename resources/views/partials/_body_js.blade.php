<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>

<!-- Optional JS -->
<script src="{{ asset('assets/vendor/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('assets/vendor/chart.js/dist/Chart.extension.js') }}"></script>

<!-- Argon JS -->
<script src="{{ asset('js/argon.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>

<script src="{{ asset('/plugin/calentim/js/moment.min.js')}}"></script>
<script src="{{ asset('/plugin/calentim/js/calentim.min.js')}}"></script>

<script src="{{ asset('/plugin/rateyo/js/jquery.rateyo.min.js') }}"></script>
<script src="{{ asset("/plugin/tinymce/js/tinymce/tinymce.min.js") }}"></script>
<script src="{{ asset('/plugin/jquery-confirm/js/jquery-confirm.min.js') }}"></script>
<!-- Dynamic Add script-->
@include('partials._dynamic_script')

<!-- Global Message -->
@include('helper.app_mesage')


