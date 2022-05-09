<!DOCTYPE html>
<html lang="en">
    <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, maximum-scale=1.0">
        <title>Gijsen Advies</title>
        <!-- Fonts -->
        
        <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.1.2/foundation.min.css">
        <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.1.2/foundation-flex.min.css">
         --><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />

       <style>


body {
  font-family: 'Open Sans', sans-serif;
}

h1,h2,h3,h4,h5 {
  font-family: 'Open Sans', sans-serif;
}

.td_yes-no, .td_drukvast,.td_debiet_measure,.td_last_sealed,.td_fabrication_year {
  text-align: center;
}

.select2-container--default .select2-selection--single {
    border-radius: 0;
    height: 2.465rem;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
  line-height: 37px;
}

        .fa-btn {
        margin-right: 6px;
        }

.top-bar {
background-color: #0f75bc !important;
color:white;
}

.top-bar ul {
background-color: #0f75bc !important;
color:white;
border: 0;
}

.top-bar li {
  background-color: #0f75bc !important;
  color:white;
}

.top-bar li a {
  color:white;
}

.textgreen {
  color: #0B9F5D;
}

.bggreen {
  background-color: #0B9F5D !important;
}

.bgred {
  background-color: #ec5840 !important;
}

.textwhite {
  color: #fff;
}
.textblue {
  color: #2199e8;
}

.textred {
  color: #ec5840;
}

.tdred {
  background-color: #ec5840;
    color: white;
    border-radius: 5px;
}

.gijsenblue { 
 color: #0f75bc;
 }

.gijsenblue_bg { 
 background-color: #0f75bc !important;
 }
       
.cd-top {
  display: inline-block;
  height: 40px;
  width: 40px;
  position: fixed;
  bottom: 40px;
  right: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
  /* image replacement properties */
  overflow: hidden;
  text-indent: 100%;
  white-space: nowrap;
  background: rgba(232, 98, 86, 0.8) url({{ asset('/images/cd-top-arrow.svg') }}) no-repeat center 50%;
  visibility: hidden;
  opacity: 0;
  -webkit-transition: opacity .3s 0s, visibility 0s .3s;
  -moz-transition: opacity .3s 0s, visibility 0s .3s;
  transition: opacity .3s 0s, visibility 0s .3s;
}
.cd-top.cd-is-visible, .cd-top.cd-fade-out, .no-touch .cd-top:hover {
  -webkit-transition: opacity .3s 0s, visibility 0s 0s;
  -moz-transition: opacity .3s 0s, visibility 0s 0s;
  transition: opacity .3s 0s, visibility 0s 0s;
}
.cd-top.cd-is-visible {
  /* the button becomes visible */
  visibility: visible;
  opacity: 1;
}
.cd-top.cd-fade-out {
  /* if the user keeps scrolling down, the button is out of focus and becomes less visible */
  opacity: .5;
}
.no-touch .cd-top:hover {
  background-color: #e86256;
  opacity: 1;
}
@media only screen and (min-width: 768px) {
  .cd-top {
    right: 20px;
    bottom: 20px;
  }
}
@media only screen and (min-width: 1024px) {
  .cd-top {
    height: 60px;
    width: 60px;
    right: 30px;
    bottom: 30px;
  }
}


th.sort-header::-moz-selection { background:transparent; }
th.sort-header::selection      { background:transparent; }
th.sort-header { cursor:pointer; }
table th.sort-header:after {
  content:'';
  float:right;
  margin-top:7px;
  border-width:0 4px 4px;
  border-style:solid;
  border-color:#404040 transparent;
  visibility:hidden;
  }
table th.sort-header:hover:after {
  visibility:visible;
  }
table th.sort-up:after,
table th.sort-down:after,
table th.sort-down:hover:after {
  visibility:visible;
  opacity:0.4;
  }
table th.sort-up:after {
  border-bottom:none;
  border-width:4px 4px 0;
  }
        </style>
    </head>
    <body id="app-layout">
        <div class="row">
            <div class="small-12 columns">
                <div class="top-bar" >
                    <div class="top-bar-left">
                       
                        <ul class="dropdown menu" data-dropdown-menu>
                            <li class="menu-text textwhite"><a href="{{url('/')}}">Gijsen Advies</a></li>
                           
                        </ul>
                        
                    </div>
                    <div class="top-bar-right">
                        <ul class="dropdown menu" data-dropdown-menu>
                            @if (Auth::guest())
                            <li class="menu-text textwhite"><a href="{{ url('/login') }}">Login</a></li>
                            @else
                            <li class="menu-text textwhite">
                                <a href="#"> {{ Auth::user()->name }} <span class="caret"></span></a>
                                <ul class="menu vertical">
                                    <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Afmelden</a></li>
                                </ul>
                            </li>
                            
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:2rem;margin-bottom: 5rem;">
            <div class="small-12 columns">
                @yield('content')
            </div>
        </div>
        <div class="row">
            <div class="small-12 columns">
            <a href="#0" class="cd-top"><i class="fa fa-angle-up"></i></a>
      </div>
      </div>

        <!-- JavaScripts -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.1.2/foundation.min.js"></script>
        {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
       
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>

  <script src="{{asset('js/tablesort.min.js')}}" type="text/javascript"></script>

        <script type="text/javascript">
        $(document).foundation();
        
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});


 

       jQuery(document).ready(function($){
    // browser window scroll (in pixels) after which the "back to top" link is shown
    var offset = 200,
        //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
        offset_opacity = 1200,
        //duration of the top scrolling animation (in ms)
        scroll_top_duration = 400,
        //grab the "back to top" link
        $back_to_top = $('.cd-top');

    //hide or show the "back to top" link
    $(window).scroll(function(){
        ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
        if( $(this).scrollTop() > offset_opacity ) { 
            $back_to_top.addClass('cd-fade-out');
        }
    });

    //smooth scroll to top
    $back_to_top.on('click', function(event){
        event.preventDefault();
        $('body,html').animate({
            scrollTop: 0 ,
            }, scroll_top_duration
        );
    });

});


$(function() {
  $('a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});



function sortTable(f,n){
  var rows = $('.sorttable tbody  tr').get();

  rows.sort(function(a, b) {

    var A = getVal(a);
    var B = getVal(b);

    if(A < B) {
      return -1*f;
    }
    if(A > B) {
      return 1*f;
    }
    return 0;
  });

  function getVal(elm){
    var v = $(elm).children('td').eq(n).text().toUpperCase();
    if($.isNumeric(v)){
      v = parseInt(v,10);
    }
    return v;
  }

  $.each(rows, function(index, row) {
    $('.sorttable').children('tbody').append(row);
  });
}


        </script>

         @yield('scripts')
    </body>
</html>