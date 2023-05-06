<body>
<div id="app">
    @include('partials._body_sidebar')
    <!-- Main content -->
    <div class="main-content">
        @include('partials._body_header')
        <div id="remoteModelData" class="modal fade" role="dialog"></div>
        @include('partials._body_contant')

    </div>
</div>

@include('partials._body_js')

<!-- Optional bottom section... -->
@yield('body_bottom')
</body>
