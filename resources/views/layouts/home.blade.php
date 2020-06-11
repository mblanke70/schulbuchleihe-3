
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="generator" content="Jekyll v3.8.5">
        <title>Buchausleihe · Ursulaschule Osnabrück</title>

        <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/dashboard/">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>
      
        <!-- Custom styles for this template -->
        <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    </head>
    <body>

        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{ url('user/') }}">Ursulaschule Osnabrück</a>
        </nav>

        <div class="container-fluid">          

            <div class="row">

            @if (Auth::user()!=null)
            
              <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                  
                  <div class="sidebar-sticky">

                      <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                          <span>Schuljahr 2020/21</span>
                      </h6>
                      <ul class="nav flex-column">
                          <li class="nav-item">
                              <a class="nav-link" href="{{ url('user/buecherlisten/4') }}">
                                  <span data-feather="home"></span>
                                    Bücherlisten
                              </a>
                          </li>
                
                          <li class="nav-item">
                              <a class="nav-link" href="{{ url('user/anmeldung/schritt1') }}">
                                  <span data-feather="file"></span>
                                  Anmeldung zum Leihverfahren
                              </a>
                          </li>
                      </ul>

                      @if(Auth::user()->jahrgang > 4)
                          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                              <span>Schuljahr 2019/20</span>
                          </h6>
                          
                          <ul class="nav flex-column">
                              <li class="nav-item">
                                  <a class="nav-link" href="{{ url('user/buecherlisten/3') }}">
                                      <span data-feather="home"></span>
                                          Bücherlisten
                                  </a>
                              </li>
                            
                              <li class="nav-item">
                                  <a class="nav-link" href="{{ url('user/buecher/3') }}">
                                      <span data-feather="file"></span>
                                          Leihbücher
                                  </a>
                              </li>       
                          </ul>
                      @endif

                  </div>
              
              </nav>
            
              @endif

              <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                      @yield('heading')
                  </div>
                  <div>
                      @yield('content')
                  </div>
              </main>
            
            </div>

        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    </body>

</html>
