<!-- header -->
<header class="header no-print">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="header-content">
                    <div class="header-logo">
                        <a href="{{ route('home.index') }}">
                            <div class="nav-logo">
                                <img src="{{ asset('/logo/logo-kami-sewain-caption-color.png') }}"
                                    alt="Logo Kami Sewain Color">
                            </div>
                        </a>
                    </div>

                    <div class="header-menu">
                        <ul class="header-nav">
                            <li class="header-nav-item">
                                <a href="{{ route('home.index') }}"
                                    class="header-nav-link {{ request()->routeIs('home.index') ? 'header-nav-active' : '' }}">Home</a>
                            </li>
                            <li class="header-nav-item">
                                <a href="{{ route('products.index') }}"
                                    class="header-nav-link {{ request()->routeIs('products.index') ? 'header-nav-active' : '' }}">Product</a>
                            </li>
                            {{-- <li class="header-nav-item">
                              <a href="{{ route('gallery.index') }}" class="header-nav-link {{ request()->routeIs('gallery.index') ? 'header-nav-active' : '' }}">Galery</a>
                            </li> --}}
                            <li class="header-nav-item">
                                <a href="{{ route('portfolio.index') }}"
                                    class="header-nav-link {{ request()->routeIs('portfolio.index') ? 'header-nav-active' : '' }}">Portfolio</a>
                            </li>
                            <li class="header-nav-item">
                                <a href="{{ route('about.index') }}"
                                    class="header-nav-link {{ request()->routeIs('about.index') ? 'header-nav-active' : '' }}">About
                                    Us</a>
                            </li>
                            <li class="header-nav-item">
                                <a href="{{ route('contacts.index') }}"
                                    class="header-nav-link {{ request()->routeIs('contacts.index') ? 'header-nav-active' : '' }}">Contact
                                    Us</a>
                            </li>
                        </ul>
                        <hr class="hr-menu-small">
                        <ul class="header-nav header-nav-auth-item">
                            @auth
                                <li class="header-nav-item">
                                    <a href="{{ route('user.show') }}"><i class="fa fa-user-circle" aria-hidden="true"></i>
                                        {{ auth()->user()->name }}</a>
                                </li>
                                <li class="header-nav-item">
                                    <a href="{{ route('orders.index') }}"><i class="fa fa-shopping-cart"
                                            aria-hidden="true"></i> Orders</a>
                                </li>
                                <li class="header-nav-item">
                                    <a href="{{ route('logout.perform') }}"><i class="fa fa-sign-out"
                                            aria-hidden="true"></i> Logout</a>
                                </li>
                            @endauth
                            @guest
                                <li class="header-nav-item"><a href="/login"><button class="header-actions-login-btn"><i
                                                class="fa fa-sign-in" aria-hidden="true"></i> Login</button></a></li>
                                <li class="header-nav-item"><a href="/register"><button
                                            class="header-actions-register-btn"><i class="fa fa-user-plus"
                                                aria-hidden="true"></i> Register</button></a></li>
                            @endguest
                        </ul>
                    </div>
                    @auth
                        <div class="header-cart">
                            <a href="{{ route('cart.view') }}">
                                <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                @if (session('cart'))
                                    <span class="cart-count">
                                        {{ session('cart') ? count(session('cart')) : 0 }}
                                    </span>
                                @endif
                            </a>
                        </div>
                        <div class="header-actions">
                          <a class="header-profile-btn" href="#" role="button" id="dropdownMenuProfile"
                             data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fa fa-user" aria-hidden="true"></i>
                          </a>
                          <ul class="dropdown-menu header-actions-container" aria-labelledby="dropdownMenuProfile">
                              <li>
                                  <a class="dropdown-item" href="{{ route('user.show') }}">
                                      <i class="fa fa-user-circle" aria-hidden="true"></i>
                                      {{ auth()->user()->name }}
                                  </a>
                              </li>
                              <li>
                                  <a class="dropdown-item" href="{{ route('orders.index') }}">
                                      <i class="fa fa-shopping-cart" aria-hidden="true"></i> Orders
                                  </a>
                              </li>
                              <li>
                                  <a class="dropdown-item" href="{{ route('logout.perform') }}">
                                      <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
                                  </a>
                              </li>
                          </ul>
                      </div>
                        {{-- <div class="header-actions">
                            <a class="header-profile-btn" href="#" role="button" id="dropdownMenuProfile"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </a>
                            <ul class="dropdown-menu header-actions-container" aria-labelledby="dropdownMenuProfile">
                                <li><a href="{{ route('user.show') }}"><i class="fa fa-user-circle" aria-hidden="true"></i>
                                        {{ auth()->user()->name }}</a></li>
                                <li><a href="{{ route('orders.index') }}"><i class="fa fa-shopping-cart"
                                            aria-hidden="true"></i> Orders</a></li>
                                <li><a href="{{ route('logout.perform') }}"><i class="fa fa-sign-out"
                                            aria-hidden="true"></i> Logout</a></li>
                            </ul>
                        </div> --}}
                    @endauth

                    @guest
                        <div class="header-actions-container">
                            <div class="header-actions-item">
                                <a href="/login">
                                    <button class="header-actions-login-btn"><i class="fa fa-sign-in"
                                            aria-hidden="true"></i> Login</button>
                                </a>
                            </div>
                            <div class="header-actions-item">
                                <a href="/register">
                                    <button class="header-actions-register-btn"><i class="fa fa-user-plus"
                                            aria-hidden="true"></i> Register</button>
                                </a>
                            </div>
                        </div>
                    @endguest
                    <button class="header-btn" type="button">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- end header -->
