<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
        <!-- Brand -->
        <div class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block"></div>
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle"> 
                        <?php 
                            $default = URL::asset(\Config::get('constant.USER.DEFAULT_IMAGE'));
                            $image = getSingleMedia(\Auth::user(),'profile_image',null) !== null ? getSingleMedia(\Auth::user(),'profile_image',null):$default ;
                        ?>
                          <!-- <img alt="Image placeholder" src="{{ $image }}"> -->
                          <img alt="Image placeholder" src="{{ getSingleMedia(\Auth::user(),'profile_image',null) }}">
                        </span>
                        <div class="media-body ml-2 d-none d-lg-block">
                            <span class="mb-0 text-sm  font-weight-bold text-primary">{{ Auth::user()->name }}</span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome!</h6>
                    </div>
                    <a href="{{ route('admin.settings') }}" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>Settings</span>
                    </a>
                    <div class="dropdown-divider"></div>
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
    </div>
</nav>
