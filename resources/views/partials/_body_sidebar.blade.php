<!-- Sidenav -->
<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
                aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> 

        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <div class="row">
                <div class="col-sm-12">
                    <img src="{{ getSingleMedia(settingSession('get'),'site_logo',null) }}" class="navbar-brand-img" alt="site_logo">
                </div>
{{--                <div class="col-sm-12">--}}
{{--                    <h1 class="text-primary m-2 mt-3"><b>{{env('APP_NAME', 'Granth')}}</b></h1>--}}
{{--                </div>--}}
            </div>
        </a>

        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <!-- <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    <i class="ni ni-bell-55"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right"
                     aria-labelledby="navbar-default_dropdown_1">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div> -->
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img alt="Image placeholder" src="{{ getSingleMedia(\Auth::user(),'profile_image',null) }}">
              </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome!</h6>
                    </div>
                    <!-- <a href="#" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>My profile</span>
                    </a> -->
                    <a href="{{ route('admin.settings') }}" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>Settings</span>
                    </a>
                    <!-- <a href="#" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>Activity</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>Support</span>
                    </a> -->
                    <div class="dropdown-divider"></div>
                    <!-- <a href="#!" class="dropdown-item">
                        <i class="ni ni-user-run"></i>
                        <span>Logout</span>
                    </a> -->
                    <a class="dropdown-item" href="{{ route('logout') }}" 
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <h1 class="text-primary m-2"><b>{{env('APP_NAME', 'Granth')}}</b></h1>
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                                data-target="#sidenav-collapse-main" aria-controls="sidenav-main"
                                aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended"
                           placeholder="Search" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
<ul class="navbar-nav">

          
@php   
    $url = '';

    $MyNavBar = \Menu::make('MenuList', function ($menu) use($url){
        
        //Admin Dashboard
        $menu->add('<span>'.__('messages.Home').'</span>', ['route' => 'home'])
            ->prepend('<i class="ni ni-tv-2 text-primary"></i>')
            ->link->attr(['class' => '']);

        //Admin Dashboard
        $menu->add('<span>'.__('messages.User').'</span>', ['route' => 'users.index'])
            ->prepend('<i class="fas fa-user text-primary"></i>')
            ->link->attr(['class' => '']);

       $menu->add('<span>'.__('messages.category').'</span>', ['route' => 'category.index'])
            ->prepend('<i class="fas fa-list text-primary"></i>')
            ->link->attr(['class' => '']);

      $menu->add('<span>'.__('messages.Subcategory').'</span>', ['route' => 'subcategory.index'])
            ->prepend('<i class="fas fa-list text-primary"></i>')
            ->link->attr(['class' => '']);

       $menu->add('<span>'.__('messages.author').'</span>', ['route' => 'author.index'])
            ->prepend('<i class="fas fa-user-edit text-primary"></i>')
            ->link->attr(['class' => '']);

      $menu->add('<span>'.__('messages.book').'</span>', ['route' => 'book.index'])
            ->prepend('<i class="fas fa-book text-primary"></i>')
            ->link->attr(['class' => '']);

      $menu->add('<span>'.__('messages.top_selling_book').'</span>',['route'  => ['book.index', 'type' => 'top-sell']])
            ->prepend('<i class="fas fa-book text-primary"></i>')
            ->link->attr(['class' => '']);

     $menu->add('<span>'.__('messages.recommended_book').'</span>', ['route'  => ['book.index', 'type' => 'recommended']])
            ->prepend('<i class="fas fa-book text-primary"></i>')
            ->link->attr(['class' => '']);

     $menu->add('<span>'.__(''.'Sales').'</span>', ['route' => 'transactions.index'])
            ->prepend('<i class="fas fa-shopping-cart text-primary"></i>')
            ->link->attr(['class' => '']);
          
     $menu->add('<span>'.__(''.'Users Feedback').'</span>', ['route' => 'users_feedback'])
            ->prepend('<i class="fas fa-comments text-primary"></i> ')
            ->link->attr(['class' => '']);

    $menu->add('<span>'.__(''.'Privacy Policy').'</span>', ['route' => 'privacy-policy'])
            ->prepend('<i class="fas fa-shield-alt text-primary"></i>')
            ->link->attr(['class' => '']);

    $menu->add('<span>'.__(''.'Term Condition').'</span>', ['route' => 'term-condition'])
            ->prepend('<i class="fas fa-handshake text-primary"></i>')
            ->link->attr(['class' => '']);

   $menu->add('<span>'.__(''.'Setting').'</span>', ['route' => 'admin.settings'])
            ->prepend('<i class="fas fa-cogs text-primary"></i>')
            ->link->attr(['class' => '']);


   $menu->add('<span>'.__('messages.mobileslider').'</span>', ['route' => 'mobileslider.index'])
            ->prepend('<i class="fas fa-mobile-alt text-primary"></i>')
            ->link->attr(['class' => '']);

  $menu->add('<span>'.__(''.'Mobile Setting').'</span>', ['route' => 'mobile_app.config'])
            ->prepend('<i class="fas fa-mobile-alt text-primary"></i>')
            ->link->attr(['class' => '']);

        }); 

@endphp
            @include(config('laravel-menu.views.bootstrap-items'), ['items' => $MyNavBar->roots()])
        </ul>
        </div>
    </div>
</nav>
