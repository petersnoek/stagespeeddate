<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

  <title>OneUI - Bootstrap 5 Admin Template &amp; UI Framework</title>

  <meta name="description" content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
  <meta name="author" content="pixelcave">
  <meta name="robots" content="noindex, nofollow">

  <!-- Icons -->
  <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
  <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

  <!-- Modules -->
  @yield('css')
  {{-- @vite(['resources/sass/main.scss', 'resources/js/oneui/app.js']) --}}
    {{-- instead of vite use vvv (the hash string is gonna be different with each dev so that's a bit annoying) --}}
    {{-- just load the main-xxxxx.css and both app-xxxxx.js that are in the public/build/assets folder --}}
    <link rel="stylesheet" href="{{ asset('build/assets/main-0fad32d9.css') }}">
    <script type="module" src="{{ asset('build/assets/app-e08ee194.js') }}"></script>
    <script type="module" src="{{ asset('build/assets/app-ca7bfba6.js') }}"></script>

  <!-- Alternatively, you can also include a specific color theme after the main stylesheet to alter the default color theme of the template -->
  {{-- @vite(['resources/sass/main.scss', 'resources/sass/oneui/themes/amethyst.scss', 'resources/js/oneui/app.js']) --}}
  @yield('js')
</head>

<body>
  <!-- Page Container -->
  <!--
    Available classes for #page-container:

    GENERIC

      'remember-theme'                            Remembers active color theme and dark mode between pages using localStorage when set through
                                                  - Theme helper buttons [data-toggle="theme"],
                                                  - Layout helper buttons [data-toggle="layout" data-action="dark_mode_[on/off/toggle]"]
                                                  - ..and/or One.layout('dark_mode_[on/off/toggle]')

    SIDEBAR & SIDE OVERLAY

      'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
      'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
      'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
      'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
      'sidebar-dark'                              Dark themed sidebar

      'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
      'side-overlay-o'                            Visible Side Overlay by default

      'enable-page-overlay'                       Enables a visible clickable Page Overlay (closes Side Overlay on click) when Side Overlay opens

      'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)

    HEADER

      ''                                          Static Header if no class is added
      'page-header-fixed'                         Fixed Header

    HEADER STYLE

      ''                                          Light themed Header
      'page-header-dark'                          Dark themed Header

    MAIN CONTENT LAYOUT

      ''                                          Full width Main Content if no class is added
      'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
      'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)

    DARK MODE

      'sidebar-dark page-header-dark dark-mode'   Enable dark mode (light sidebar/header is not supported with dark mode)
  -->
  <div id="page-container" class="page-header-fixed">

    <header id="page-header" class="shadow-sm; position:absolute;">
      <!-- Header Content -->
      <div class="content-header">
        <!-- Left Section -->
        <div class="d-flex align-items-center">     
          <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
          </a>  
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="d-flex align-items-center">
          <!-- User Dropdown -->
          @guest
            @if (Route::has('login'))
                <button type="button" class="btn btn-sm btn-alt-secondary d-flex align-items-center mx-2">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </button>
            @endif

            @if (Route::has('register'))
                <div type="button" class="btn btn-sm btn-alt-secondary d-flex align-items-center mx-2">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </div>
            @endif
          @else
            <div class="dropdown d-inline-block ms-2">
              <button type="button" class="btn btn-sm btn-alt-secondary d-flex align-items-center" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="rounded-circle" src="{{ asset(Auth::user()->profilePicture) }}" alt="Header Avatar" style="width: 21px; height: 21px;">
                <span class="d-none d-sm-inline-block ms-2">{{ Auth::user()->first_name }}</span>
                <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block ms-1 mt-1"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0" aria-labelledby="page-header-user-dropdown">
                <div class="p-3 text-center bg-body-light border-bottom rounded-top">
                  <img class="img-avatar img-avatar48 img-avatar-thumb" src="{{ asset(Auth::user()->profilePicture) }}" alt="">
                  <p class="mt-2 mb-0 fw-medium">{{ Auth::user()->first_name }}</p>
                  <p class="mb-0 text-muted fs-sm fw-medium">{{ Auth::user()->email }}</p>
                </div>
                <div class="p-2">
                  <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                    <span class="fs-sm fw-medium">Profile</span>
                    {{-- <span class="badge rounded-pill bg-primary ms-2">1</span> --}}
                  </a>
                </div>
                <div role="separator" class="dropdown-divider m-0"></div>
                <div class="p-2">
                  {{-- <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                    <span class="fs-sm fw-medium">Log Out</span>
                  </a> --}}
                  <a class="dropdown-item d-flex align-items-center justify-content-between"
                    onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
                    <span class="fs-sm fw-medium">{{ __('Log Out') }}</span>
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                  </form>
                </div>
              </div>
            </div>
          @endguest
          <!-- END User Dropdown -->
        </div>
        <!-- END Right Section -->
      </div>
      <!-- END Header Content -->

      <!-- Header Loader -->
      <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
      <div id="page-header-loader" class="overlay-header bg-body-extra-light">
        <div class="content-header">
          <div class="w-100 text-center">
            <i class="fa fa-fw fa-circle-notch fa-spin"></i>
          </div>
        </div>
      </div>
      <!-- END Header Loader -->
    </header>

    <!-- Main Container -->
    <main id="main-container" class="pt-7">
      @yield('content')
    </main>
    <!-- END Main Container -->
  </div>
  <!-- END Page Container -->
</body>

</html>
