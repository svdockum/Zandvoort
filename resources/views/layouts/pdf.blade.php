<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gijsen Advies</title>
        <!-- Styles -->

        <style>

body {
  font-family: 'Open Sans', sans-serif;
}

h1,h2,h3,h4,h5 {
  font-family: 'Open Sans', sans-serif;
}

table.smalltext th {
  text-align: left;
}

table.smalltext {
  font-size: 0.8rem;
}

table.smalltext td, table.smalltext th {
  padding-left: 10px;
  padding-right: 10px;
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

.textwhite {
  color: #fff;
}
.textblue {
  color: #2199e8;
}

.textred {
  color: #ec5840;
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
  background: rgba(232, 98, 86, 0.8) url(/images/cd-top-arrow.svg) no-repeat center 50%;
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
.page-break {
    page-break-after: always;
}

table.border {
    border-collapse: collapse;
}
table.border td {
   border: 1px solid #ccc;
}


.landscape {
  @page { size: a4 landscape; }
}

.w25 {
  width: 25px;
}
.w50 {
  width: 50px;
}
.w75 {
  width: 75px;
}
.w100 {
  width: 100px;
}
.w125 {
  width: 125px;
}
.w150 {
  width: 150px;
}
.w175 {
  width: 175px;
}
.w200 {
  width: 200px;
}
.w225 {
  width: 225px;
}
.w250 {
  width: 250px;
}




        </style>
    </head>
    <body id="app-layout">
        <div class="row" style="margin-top:2rem;">
            <div class="small-12 columns">
                @yield('content')
            </div>
        </div>
    </body>
</html>