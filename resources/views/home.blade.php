@extends('layouts.app')

@section('content')


     <div class="row">
            <div class="small-12 columns">
                <h2>Selecteer klant</h2>
            </div>
        </div>
        <div class="row" id="try">
            <div class="small-12 columns" data-sticky-container>
                <div class="sticky"  data-sticky data-top-anchor="try" data-btm-anchor="destroy:bottom"   >
                <?php
                $azRange = range('A', 'Z');
                foreach ($azRange as $char)
                {
                    echo '<a href="#'.$char.'" class="button" style="padding:0.8rem" >'.$char.'</a>&nbsp;&nbsp;';
                }
                ?>
                </div>
            </div>
        </div>
        
        <div class="row" >
            <div class="small-12 columns" >
               
               <?php
               $tempchar = '';
                 
               foreach ($customers as $customer) {
               
               if ($customer->name[0] <> $tempchar) {
                $tempchar = $customer->name[0];
                echo '
                <div style="margin-bottom:70px;"><a name="'.$tempchar.'" id="'. $tempchar.'"></a></div><h4>'. $tempchar.'</h4>';
                
               }
                
                ?>
                
               
                    <div class="row" style="margin-bottom: 1rem;">
                        <div class="small-12 columns">
                            <div class="row align-middle">
                                <div class="small-3 columns text-center">
                                   <a href="{{url('/customer/' . $customer->id )}}">  
                                   @if (empty($customer->logo))
                                       <img style="height: 100px;" src="https://placehold.it/250x100/eeeeee?text=Geen logo" />
                                   @else 
                                    <img style="height: 100px;" src="{{ 'customerlogos/'. $customer->id . '/' . $customer->logo}}" />
                                    @endif
                                    </a>
                                </div>
                                <div class="small-7 columns">
                                    <a href="{{url('/customer/' . $customer->id )}}"> <h2>{{ $customer->name }}</h2> </a>
                                    @if ($customer->isNood)
                        <span class="fa-stack fa-lg textgreen" style="font-size: 0.7rem;">
                            <i class="fa fa-square-o fa-stack-2x"></i>
                            <i class="fa fa-lightbulb-o" style="margin-left: 8px;"></i>
                        </span>
                        @endif 
                        @if ($customer->isAlarm)
                        <span class="fa-stack fa-lg textred" style="font-size: 12px;">
                            <i class="fa fa-square-o fa-stack-2x"></i>
                            <i class="fa fa-bell" style="margin-left: 6px;"></i>
                        </span>
                        @endif 
                        @if ($customer->isBMI)
                        <span class="fa-stack fa-lg textblue" style="font-size:12px;">
                            <i class="fa fa-square-o fa-stack-2x"></i>
                            <i class="fa fa-align-center" style="margin-left: 6px;"></i>
                        </span>
                        @endif 
                                </div>
                                <div class="small-2 columns text-right">
                                   @if (in_array(\Auth::user()->role,[1]))<a href="{{url('/customer/edit/'. $customer->id )}}"><h4><i class="fa fa-pencil-square-o"></i></h4></a>@endif
                                </div>
                            </div>
                        </div>
                    </div>
               
                <?php 

                }

                ?>
               
            </div>
        </div>

<div id="spacer" style="margin-top: 1000px;">&nbsp;</div>
<div id="destroy">
 </div>
@endsection
