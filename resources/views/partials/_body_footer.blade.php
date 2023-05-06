<!-- Footer -->
<footer class="py-5 footer">
    <div class="container">
        <div class="row align-items-center justify-content-xl-between">
            <div class="col-xl-6">
                <div class="copyright text-center text-xl-left text-muted">
                    &copy; {{ date('Y') }} <a href='{{ route("home") }}' class="font-weight-bold ml-1" target="_blank">{{env('APP_NAME', 'Granth')}}</a>
                </div>
            </div>
        </div>
    </div>
</footer>
