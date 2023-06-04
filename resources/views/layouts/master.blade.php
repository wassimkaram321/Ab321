<html>
    <head>
        <!-- Other head content -->
        @include('layouts.partials.styles')
        
    </head>
    <body>
      
        <div class="">
          
            <div class="row">
              
                <div class="col-2">
                    @include('layouts.sidebar')
                </div>
                <div class="col-10">
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
    @include('layouts.partials.scripts')
</html>