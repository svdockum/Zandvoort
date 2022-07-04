@extends('layouts.app')
@section('content')

<div class="row " style="margin-bottom: 2rem;">
    <div class="small-12 columns">
        <div class="row">
            <div class="small-3 columns text-center">
                @if (empty($customer->logo))
                                       <img style="height: 100px;" src="https://placehold.it/250x100/eeeeee?text=Geen logo" />
                                   @else 
                                    <img style="height: 100px;" src="{{ asset('customerlogos/'. $customer->id . '/' . $customer->logo)}}" />
                                    @endif
            </div>
            <div class="small-6 columns align-middle">
                <h4>{{$customer->name}}</h4>
                <small>{{$location->name}} {{$location->street}} {{$location->housenumber}},<br> {{$location->postalcode}}, {{$location->city}}<br><!--<a href="#">Aanpassen</a>--></small>
<a href="{{ url('/report/'. $report->id .'/selectlocation') }}" id="changeloc" class="offlinedisable">Locatie aanpassen</a> | <a href="{{url()->current() . '/edit'}}">Aanpassen datum/monteur</a>
            </div>
            <div class="small-3 columns align-middle text-right offlinedisable">
                <a href="{{ url('/customer/'. $customer->id)}}" class="button @if ($type == 'blusmiddelen') bgred @endif @if ($type == 'keerkleppen') blue @endif @if ($type == 'noodverlichting') bggreen @endif"><i class="fa fa-btn fa fa-caret-left"></i>Terug naar Overzicht</a>
                <div style="display: inline-block;height: 1rem;vertical-align: top;padding-top: 8px;padding-right: 23px;">Gereed?</div>
                    <div class="switch large" style="display: inline-block;">
                    <input class="switch-input" id="ready" type="checkbox" name="ready" value="Ja" @if (empty($report->report_ready))  @else checked  @endif>
                    <label class="switch-paddle @if ($type == 'blusmiddelen') bgred @endif @if ($type == 'keerkleppen') blue @endif @if ($type == 'noodverlichting') bggreen @endif" for="ready">
                      <span class="switch-active" aria-hidden="true" style="left: 20%;">Ja</span>
                      <span class="switch-inactive" aria-hidden="true" style="right: 10%;">Nee</span>
                    </label>
                    </div>
                                </div>
        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="small-12 columns">
                       <label style="display:inline;" for="kenmerk">Kenmerk: </label>
                        <input style="width:200px;display:inline;" type="text" id="kenmerk" name="kenmerk" value="{{$report->name}}"/>
                        <a href="#" class="button small bggreen" id="addkenmerk" data-key="" style="margin-top:15px;">Kenmerk opslaan</a>
     </div>
</div>

<div class="row">
        <div class="small-12 columns">
            <h4>{{ ucfirst($type) }} Rapport - {{$report->created_at->format('Y')}}</h4>
            <small>Aangemaakt op: {{$report->created_at->format('d-m-Y')}}, door <?php

$username = \App\User::find($report->user_id);
if (!empty($username)) {
    $username = $username->name;
}
else {
    $username = '-';
}

 if (!empty($report->otheruser)) {
    $username = $report->otheruser;
 }

 echo $username;

?>
            </small> 
            <br><br>
        </div>
</div>

<div id="message" style="color:red;font-weight: bold;"></div>
       
<div class="row">
            <div class="small-12 medium-1 columns" style="padding-right:0px;">

                        <label for="pos">Pos.</label>
                        <input type="text" id="pos" name="pos" value="" />
            </div>
            <div class="small-12 medium-2 columns" >
                         <label for="pos">Etage</label>
                       <select id="etage" name="etage">
                           <option>B.G.</option>
                            <option>Kelder -1</option>
                             <option>Kelder -2</option>
                              <option>Kelder -3</option>
                               <option>Kelder -4</option>
                                <?php 
                                for ($i = 1;$i <= 20;$i++) {
                                  echo '<option>'.$i.'e verd.</option>';
                                  
                                } ?>
                            </select>
            </div>
            <div class="small-12 medium-3 columns">
                         <label for="pos">Ruimte</label>
                        <input type="text" id="location" name="location" />
            </div>
            
            <div class="small-12 medium-3 columns">
                         <label for="pos">Type Picto</label>
                        <select id="picto" name="picto" class="s2">
                            <option>-</option>
                            <option>vluchtroute rechtdoor of naar boven</option>
                            <option>vluchtroute rechtsaf</option>
                            <option>vluchtroute linksaf</option>
                            <option>vluchtroute linksaf/rechtsaf</option>
                            <option>vluchtroute naar beneden</option>
                            <option>vluchtroute trap af rechts</option>
                            <option>vluchtroute trap op rechts</option>
                            <option>vluchtroute trap af links</option>
                            <option>vluchtroute trap op links</option>

                        </select>
            </div>
             <div class="small-12 medium-3 columns">
              <label for="pos">Autonomiteitsduur 60 minuten:</label>
                        
                        <select id="autonomiteits" name="autonomiteits">
                            <option value="1">Ja</option>
                            <option value="0">Nee</option>
                            </select>
                  
            </div>
        </div>

        <div class="row">
                   <div class="medium-3 columns">
                                                
                        <label for="arm_merk">Armatuur Fabrikaat</label>
                        <select id="arm_merk" name="arm_fabrikaat" class="s2">
                            <option >-</option>
                            @foreach (\App\Brand::where('category','=','armatuur')->get() as $brand)
                            
                              <option>{{ $brand->name }}</option>
                            
                            @endforeach
                            <!--
                            <option>Van Lien</option>
                            <option>Blessing</option>
                            <option>Famostar</option>
                            <option>Fagerhult</option>
                            <option>Hertek</option>
                            <option>Philips</option>
                            <option>Dlight</option>
                            <option>Bega</option>-->
                        </select>
                        <label for="arm_type">Armatuur Type</label>
                        <select id="arm_type" name="arm_type" class="s2">
                            <option >-</option>
                            @foreach (\App\Type::where('category','=','armatuur')->get() as $brand)
                            
                              <option>{{ $brand->name }}</option>
                            
                            @endforeach
                            <!--
                            <option>Van Lien</option>
                            <option>Blessing</option>
                            <option>Famostar</option>
                            <option>Fagerhult</option>
                            <option>Hertek</option>
                            <option>Philips</option>
                            <option>Dlight</option>
                            <option>Bega</option>-->
                        </select>
                       <!--  <input type="text" id="arm_type" name="arm_type" style="margin-bottom: 0;" /> -->
                        <label for="arm_nr">Typenummer</label>
                         <input type="text" id="arm_nr" name="arm_nr" style="margin-bottom:0px;" />
                       
                       
                    </div> 
                    <div class="medium-3 columns">
                        <!-- <label for="cont_merk" >Continu Merk:</label>
                        <select id="cont_merk" name="cont_merk" class="s2">
                            <option>-</option>
                             @foreach (\App\Brand::where('category','=','continu')->get() as $brand)
                            
                              <option>{{ $brand->name }}</option>
                            
                            @endforeach
                           
                        </select>
                        <label for="cont_type" >Continu Type</label>
                            <select id="cont_type" name="cont_type">
                            <option>-</option>  
                           @foreach (\App\Type::where('category','=','continu')->get() as $brand)
                            
                              <option>{{ $brand->name }}</option>
                            
                            @endforeach
                             </select>
                        <label for="cont_nr" >Typenummer</label>
                              <input type="text" id="cont_nr" name="cont_nr"  />
                            -->
                    </div>
                    <div class="medium-3 columns">
                      <!--  <label for="nood_merk" >Nood Merk:</label>
                        <select id="nood_merk" name="nood_merk" class="s2">
                             <option>-</option>
                              @foreach (\App\Brand::where('category','=','nood')->get() as $brand)
                            
                              <option>{{ $brand->name }}</option>
                            
                            @endforeach
                            
                        </select>
                        <label for="nood_type">Nood type</label>
                            <select id="nood_type" name="nood_type">
                            <option>-</option>
                          @foreach (\App\Type::where('category','=','nood')->get() as $brand)
                            
                              <option>{{ $brand->name }}</option>
                            
                            @endforeach
                            </select>
                        <label for="nood_nr">Typenummer</label>
                         <input type="text" id="nood_nr" name="nood_nr"  />
                            -->
                   </div>
                   <div class="medium-3 columns">
                         <label for="bat_merk" >Batterij Merk:</label>
                        <select id="bat_merk" name="bat_merk" class="s2">
                            <option>-</option>
                               @foreach (\App\Brand::where('category','=','battery')->get() as $brand)
                            
                              <option>{{ $brand->name }}</option>
                            
                            @endforeach

                            <!-- <option>Van Lien</option>
                              <option>Saft</option>-->
                        </select>
                        <label for="bat_type">Batterij type</label>
                            <select id="bat_type" name="bat_type">
                             <option>-</option> 
                               @foreach (\App\Type::where('category','=','batterij')->get() as $brand)
                            
                              <option>{{ $brand->name }}</option>
                            
                            @endforeach
                             <!--  <option>Ni-Cd (naast elkaar)</option>
                                <option>Ni-Cd (staaf)</option>
                                <option>Ni-MH</option>
                                <option>Lood</option>-->
                            </select>
                        <label for="bat_nr">Montage datum</label>
                            <input type="text" id="bat_nr" name="bat_nr" style="margin-bottom:0px;" />
                    </div>
        
        </div>
        <div class="row">
            <div class="medium-3 columns text-center">
            <div class="row">
            <div class="small-6 columns">
               <div style="display:inline-block;" class="text-center"> 
                   <label for="handtest">Handtest uitg.</label>
                    <div class="switch large">
                    <input class="switch-input" id="handtest" type="checkbox" name="handtest" value="Ja" checked>
                    <label class="switch-paddle @if ($type == 'blusmiddelen') bgred @endif @if ($type == 'keerkleppen') blue @endif @if ($type == 'noodverlichting') bggreen @endif" for="handtest">
                      <span class="switch-active" aria-hidden="true" style="left: 20%;">Ja</span>
                      <span class="switch-inactive" aria-hidden="true" style="right: 10%;">Nee</span>
                    </label>
                  </div>
                </div>
                </div>
                <div class="small-6 columns">
               <div style="display:inline-block;" class="text-center"> 
                   <label for="lbcont_verv">LB Continu verv.?</label>
                    <div class="switch large">
                    <input class="switch-input" id="lbcont_verv" type="checkbox" name="lbcont_verv" value="Ja" checked>
                    <label class="switch-paddle @if ($type == 'blusmiddelen') bgred @endif @if ($type == 'keerkleppen') blue @endif @if ($type == 'noodverlichting') bggreen @endif" for="lbcont_verv">
                      <span class="switch-active" aria-hidden="true" style="left: 20%;">Ja</span>
                      <span class="switch-inactive" aria-hidden="true" style="right: 10%;">Nee</span>
                    </label>
                  </div>
                    
                </div>
            </div>
            </div>
            <div class="row">
            <div class="small-6 columns">
           <!-- <input id="checkbox1" type="checkbox"><label for="checkbox1">n.v.t</label>-->
            </div>
            <div class="small-6 columns">
            <!-- <input id="checkbox2" type="checkbox"><label for="checkbox2">n.v.t</label>-->
            </div>

            </div>
            </div>
           
<div class="medium-3 columns text-center">
            <div class="row">
            <div class="small-6 columns">
               <div style="display:inline-block;" class="text-center"> 
                   <label for="lbnood_verv">LB Nood verv.?</label>
                    <div class="switch large">
                    <input class="switch-input" id="lbnood_verv" type="checkbox" name="lbnood_verv" value="Ja" checked>
                    <label class="switch-paddle @if ($type == 'blusmiddelen') bgred @endif @if ($type == 'keerkleppen') blue @endif @if ($type == 'noodverlichting') bggreen @endif" for="lbnood_verv">
                      <span class="switch-active" aria-hidden="true" style="left: 20%;">Ja</span>
                      <span class="switch-inactive" aria-hidden="true" style="right: 10%;">Nee</span>
                    </label>
                  </div>
                </div>
                </div>
                <div class="small-6 columns">
               <div style="display:inline-block;" class="text-center"> 
                   <label for="batt_verv">Batterij verv.?</label>
                    <div class="switch large">
                    <input class="switch-input" id="batt_verv" type="checkbox" name="batt_verv" value="Ja" checked>
                    <label class="switch-paddle @if ($type == 'blusmiddelen') bgred @endif @if ($type == 'keerkleppen') blue @endif @if ($type == 'noodverlichting') bggreen @endif" for="batt_verv">
                      <span class="switch-active" aria-hidden="true" style="left: 20%;">Ja</span>
                      <span class="switch-inactive" aria-hidden="true" style="right: 10%;">Nee</span>
                    </label>
                  </div>
                    
                </div>
            </div>
            </div>
            <div class="row">
            <div class="small-6 columns">
         <!--    <input id="checkbox1" type="checkbox"><label for="checkbox1">n.v.t</label>-->
            </div>
            <div class="small-6 columns">
         <!--    <input id="checkbox1" type="checkbox"><label for="checkbox1">n.v.t</label>-->
            </div>

            </div>
            </div>
         
           <div class="medium-3 columns text-center">
            <div class="row">
            <div class="small-6 columns">
               <div style="display:inline-block;" class="text-center"> 
                   <label for="damage">Controle schade?</label>
                    <div class="switch large">
                    <input class="switch-input" id="damage" type="checkbox" name="damage" value="Ja" checked>
                    <label class="switch-paddle @if ($type == 'blusmiddelen') bgred @endif @if ($type == 'keerkleppen') blue @endif @if ($type == 'noodverlichting') bggreen @endif" for="damage">
                      <span class="switch-active" aria-hidden="true" style="left: 20%;">Ja</span>
                      <span class="switch-inactive" aria-hidden="true" style="right: 10%;">Nee</span>
                    </label>
                  </div>
                </div>
                </div>

                          <div class="small-6 columns">
               <div style="display:inline-block;" class="text-center"> 
                   <label for="ok">Goedgekeurd?</label>
                    <div class="switch large">
                    <input class="switch-input" id="ok" type="checkbox" name="ok" value="Ja" checked>
                    <label class="switch-paddle @if ($type == 'blusmiddelen') bgred @endif @if ($type == 'keerkleppen') blue @endif @if ($type == 'noodverlichting') bggreen @endif" for="ok">
                      <span class="switch-active" aria-hidden="true" style="left: 20%;">Ja</span>
                      <span class="switch-inactive" aria-hidden="true" style="right: 10%;">Nee</span>
                    </label>
                  </div>
                </div>
                </div>
          
            </div>
            <div class="row">
            <div class="small-12 columns">
           <!--  <input id="checkbox1" type="checkbox"><label for="checkbox1">n.v.t</label>-->
            </div>
        

            </div>
            </div>

           <div class="medium-3 columns text-left">
            
               <label for="pos">Opmerkingen</label>
                       <input type="text" id="remarks" name="remarks" />
            </div>
            
         </div>
           
     
       

        <div class="row">
              <div class="small-12 medium-8 columns">
              <label for="notes">Eigen opmerkingen</label>
              <textarea id="notes" name="notes"></textarea>
              </div>
              <div class="small-12 medium-4 columns align-middle text-center">
                <a href="#" class="button large @if ($type == 'blusmiddelen') bgred @endif @if ($type == 'keerkleppen') blue @endif @if ($type == 'noodverlichting') bggreen @endif" id="addrow" data-key="" style="margin-top:15px;">Invoeren</a>
                <span id="showCopyNr"><br>Aantal keer invoeren:<input type="number" min="1" id="copyNr" style="width:80px;display:inline;"></span>
            </div>
            </div>
        <hr style="height: 1px;color:#ccc;">

        <div class="row" style="margin-bottom: 8rem;">
            <table id="dynamicrows" class="sorttable" style="font-size: 0.7rem;">
                            <!--dynamic rows -->
            </table>
        </div>

@endsection

@section('scripts')

<script>
var pos = 1;
var offline = false;
var uniquekey = 'gijsenadvies-';
var report = <?php echo $report->id;?>;

var branddata;
var typedata;
var blusstof;

var prefix = uniquekey + report + '-';
var dateprefix = uniquekey + '-date-'+ report;

var data ={};
var tkeyvals = {};
var latestpos = 0;


<?php if (!empty($report->json)) { ?>
localStorage.setItem(prefix,<?php echo "'" . str_replace('\t', "",$report->json) . "'"; ?>);
<?php } ?>

//load initial values
RewriteFromStorage();



$('select').select2({ 
        createSearchChoice:function(term, data) { 
        if ($(data).filter(function() { 
            return this.text.localeCompare(term)===0; 
        }).length===0) 
        {return {id:term, text:term};} 
    },
    multiple: false,
    tags: true,
    selectOnBlur: true
    });

//CLICK Events
/////////////////////////////////////////////////////////////
$("#addrow").click(function (e) {
e.preventDefault();

if ($('#addrow').html() == 'Aanpassen') {
    console.log('edit');

    //get the data from local. loop till got right key (loop further) save again
     delete data[$(this).data('key')];
     $(this).data('key','');
     $('#addrow').html('Invoeren');
     $('#showCopyNr').show();
    
}
        
        if ($('#copyNr').val() > 1) {
        console.log($('#copyNr').val() + "copy times"); 
            let loopcounter = parseInt($('#copyNr').val(),10);
            console.log(loopcounter + "|||||||||||||||||||||||");
            for (let i = 0;i < loopcounter;i++) {
    
    
                keyvals = {};
    
    $('input,select,textarea').each(function(){
    

  if ($(this).attr('id') != 'ready') {
   if ($(this).attr('id') != 'copyNr') {
    if ($(this).attr('id') != 'remarks') {
        
        if ($(this).is(':checkbox')) {
            if ( $(this).prop('checked') == true) {
                    keyvals[ $(this).attr('id')] =  $(this).val();
            }
            else {
                    keyvals[ $(this).attr('id')] =  0;
            }
        }
        else if ($(this).hasClass('s2')) {
            try {
               
               var textvalue = $(this).select2('data')[0]['text']
            keyvals[ $(this).attr('id')] = escapeHtml(textvalue);
            console.log($(this).select2('data')[0]['text']);
            }
            catch (error) {
                keyvals[ $(this).attr('id')] = "-"; //no text filled in
            }
        }
        else if ( typeof $(this).attr('id') != 'undefined'){
          console.log($(this).attr('id'));
    
        if ($(this).attr('id') == 'pos') {
            keyvals[ $(this).attr('id')] =  parseInt(escapeHtml($(this).val()),10) + i;
        }
        else {
            keyvals[ $(this).attr('id')] =  escapeHtml($(this).val());
        }
    
    }

     }
    }
}
});


        keyvals['remarks'] =  $('#remarks').val();
    
    
                data['row'+guid()] = keyvals ;
                localStorage.setItem(prefix,JSON.stringify(data));
            }

        }
        else {

            keyvals = {};
    
    $('input,select,textarea').each(function(){
    

  if ($(this).attr('id') != 'ready') {
   if ($(this).attr('id') != 'copyNr') {
    if ($(this).attr('id') != 'remarks') {
        
        if ($(this).is(':checkbox')) {
            if ( $(this).prop('checked') == true) {
                    keyvals[ $(this).attr('id')] =  $(this).val();
            }
            else {
                    keyvals[ $(this).attr('id')] =  0;
            }
        }
        else if ($(this).hasClass('s2')) {
            try {
               
               var textvalue = $(this).select2('data')[0]['text']
            keyvals[ $(this).attr('id')] = escapeHtml(textvalue);
            console.log($(this).select2('data')[0]['text']);
            }
            catch (error) {
                keyvals[ $(this).attr('id')] = "-"; //no text filled in
            }
        }
        else if ( typeof $(this).attr('id') != 'undefined'){
          console.log($(this).attr('id'));
                keyvals[ $(this).attr('id')] =  escapeHtml($(this).val());
        }

        }
    }
}
})


        keyvals['remarks'] =  $('#remarks').val();
    



            data['row'+guid()] = keyvals ;
        localStorage.setItem(prefix,JSON.stringify(data));
        }

        if (!offline) log(data);
        
        RewriteFromStorage();
});


$('body').on('click', 'a.editbtn', function(event) {
    event.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, "slow");
    $('#addrow').html('Aanpassen');
    $('#showCopyNr').hide();
    $('#addrow').data('key',$(this).data('key'));

    console.log($(this).data('key'));
    //load all from row
    var row = data[$(this).data('key')];
     Object.keys(row).forEach(function(nkey,index) {
       // console.log(nkey);

         if (nkey.indexOf('_merk') >= 0
              || nkey.indexOf('_type') >= 0
               || nkey.indexOf('etage') >= 0
            
                || nkey.indexOf('picto') >= 0
                || nkey.indexOf('autonomiteits') >= 0
             

                                      ) {
              //$('#'+nkey).select2('text',row[nkey]);
              
              $("#"+nkey+ ' option').removeAttr("selected").trigger('change');
              //check of hij bestaat
              if ($("#"+nkey +" option:contains('"+row[nkey]+"')").length > 0) {
                
                $("#"+nkey+ ' option').each(function () { 
                  if ($(this).html() == row[nkey]) {
                          $(this).prop("selected", "selected");
                          $("#"+nkey).trigger('change');
                          return;
                      }
                  });
              }
              else {
                $('#'+nkey).append('<option selected value="'+row[nkey]+'">'+row[nkey]+'</option>').val(row[nkey]).trigger('change');        
              }
        
         }
         else if (nkey.indexOf('lbcont_verv') >= 0
                                      || nkey.indexOf('lbnood_verv') >= 0
                                      || nkey.indexOf('batt_verv') >= 0
                                      || nkey.indexOf('damage') >= 0
                                      || nkey.indexOf('handtest') >= 0
                                      || nkey.indexOf('ok') >= 0) {
            console.log(row[nkey]);
            if (row[nkey] != 'Ja')
                $('#'+nkey).prop('checked',false);
            else {
               $('#'+nkey).prop('checked',true);
            }
         }
         else {
        //    console.log(row[nkey]);
            $('#'+nkey).val(row[nkey]);
         }
    });

     try {
    var texttype = $('#type').select2('data')[0]['text'];

    if (texttype == 'Water') {
        $('#last_sealed').attr('disabled',false);
        $('#debiet_measure').attr('disabled',false);
      }
    else {
        $('#last_sealed').attr('disabled',true);
        $('#debiet_measure').attr('disabled',true);
        $('#last_sealed').val(0);
        $('#debiet_measure').val('');
    }
    } catch (err) { //ini problem no catch needed.
    }

});


$('body').on('click', 'a.deletebtn', function(event) {
    event.preventDefault();
    delete data[$(this).data('key')];
    console.log($(this).data('key'));
    localStorage.setItem(prefix,JSON.stringify(data));
    if (!offline) log(data);
    RewriteFromStorage();

});
     
//END CLICK Events
/////////////////////////////////////////////////////////////


// Register listeners
/////////////////////////////////////////////////////////////
window.addEventListener("offline", function(){
    $("#message").html('Waarschuwing, er is geen internet verbinding! Invullen is mogelijk, als er weer verbinding is wordt het rapport gesynchroniseerd. Dit scherm niet vernieuwen.').show();
offline = true;
$('.offlinedisable').fadeOut('slow');
    //activate button
});

window.addEventListener("online", function(){
    offline = false;
    $("#message").html('Er is weer internet, het rapport wordt gesynchroniseerd.').show();
    savedata();
    setTimeout(function(){ 
    $("#message").fadeOut('slow'); }, 2000);
    $('.offlinedisable').fadeIn('slow');
});
// END Register listeners
/////////////////////////////////////////////////////////////


// Triggers
/////////////////////////////////////////////////////////////

 $('#brand').on("select2:select", function (e) { 
    $("#type").html('').trigger('change');
 
    var brandid = $('#brand').val();
    
    //var url = '<?php echo url('data/blus/type') ?>' + '/'+brandid;
    // $.get(url, function( data ) {

        findTypes(brandid);
        if (data.length == 0) data = '';
        
         $('#type').select2({ 
        data:typeListArray,
        createSearchChoice:function(term, data) { 
        if ($(data).filter(function() { 
            return this.text.localeCompare(term)===0; 
        }).length===0) 
        {return {id:term, text:term};} 
    },
    multiple: false,
    tags: true,
    selectOnBlur: true
    });

    
    fillMaterials($('#type').val())
 
    // });
    
  });


 $('#type').on("select2:select", function (e) { 
        $("#material").html('').trigger('change');
        fillMaterials($('#type').val());
    });



//FUNCTIONS
function resetSelects() {
    //$("select").selectedIndex = 0
    //$('select').find("select option:eq(0)").prop("selected", true).trigger('change');
    $('select').val('-').trigger('change');
    $('input:text:not(#kenmerk)').val('');
    $('input:checkbox').not("#ready").prop('checked',true);

    $('#etage').val('B.G.').trigger('change');
    $('#pos').val(latestpos);
    $('#notes').val('');
    $('#copyNr').val('1');
    $('#autonomiteits').val('1').trigger('change');

    
  
   
}

            function RewriteFromStorage() {
                pos = 1;
             

                    $("#dynamicrows").html('<thead> <tr> <th style="width:150px" id="sl" data-sort-order="asc" class="sort-default" data-sort-method="number">Pos.</th><th>Locatie</th><th>Picto</th> <th>Duur</th> <th>Armatuur</th><th>Batterij</th><th>Tests</th><th>Opmerkingen</th> <th class="text-center">Aanpassen</th><th class="text-center">Verwijderen</th> </tr></thead>');
                    

                    for(var i = 0; i < localStorage.length; i++) {
                            
                        var key = localStorage.key(i);


                        if(key.indexOf(prefix) == 0) {
                                    
                            var getitem = localStorage.getItem(key); 
                                     if (getitem != '') {
                            //set global data
                           customer_rows = JSON.parse(getitem);
                           // data=customer_rows = getitem;
                                    
                            var str = '';
            
                            Object.keys(customer_rows).forEach(function(key,index) {
                                  var datarow_guid = key;
                                  keyvals = {};

                                str += '<tr>';
                                            
                                Object.keys(customer_rows[key]).forEach(function(nkey,index) {
                                    keyvals[nkey] = customer_rows[key][nkey];

                                    if (nkey != 'notes' && nkey != 'kenmerk') {
                                      
                                    if (nkey == 'pos') {
                                      str += '<td class="td_' + nkey +'">'+ customer_rows[key][nkey] +'';
                                    }
                                    else if (nkey == 'location') {
                                      str += '<br>' + customer_rows[key][nkey];
                                    }
                                    else if (
                                       nkey.indexOf('lbcont_verv') >= 0
                                      || nkey.indexOf('lbnood_verv') >= 0
                                      || nkey.indexOf('batt_verv') >= 0
                                      || nkey.indexOf('damage') >= 0
                                      || nkey.indexOf('ok') >= 0
                                      ) {

                                      if (customer_rows[key][nkey] == 0) {
                                         str += '<br>Nee';
                                      }
                                      else {
                                        str += '<br>' + customer_rows[key][nkey];
                                      }

                                    }
                                    else if (nkey.indexOf('_type') >= 0 || nkey.indexOf('_nr') >= 0) {
                                        str += '<br>' + customer_rows[key][nkey];
                                    }
                                    else {
                                      if (nkey == 'handtest' && customer_rows[key][nkey] == 0) {
                                     str += '</td><td class="td_' + nkey +'">Nee';
                                      }
                                      else {
                                     str += '</td><td class="td_' + nkey +'">'+ customer_rows[key][nkey] +'';
                                      }
                                    }
                                  }

                                    //set global data
                                    data[datarow_guid] = keyvals ;
                                    //set latest position
                                    pos = parseInt(customer_rows[key]['pos']) + 1;
                                });
                                   
                                <?php
                                $extraclass = '';
                                if ($type == 'noodverlichting') $extraclass = 'bggreen';
                                ?>
                                str += '</td><td class="text-center"><a class="editbtn button <?php echo $extraclass; ?> " href="#" data-key="'+key+'"><i class="fa fa-pencil-square-o"></i></a></td><td class="text-center"><a class="deletebtn button <?php echo $extraclass; ?>" href="#" data-key="'+key+'"><i class="fa fa-trash-o"></i></a></td>';
                                str += '</tr>';
                                
                        });

                        $("#dynamicrows").append(
                                $("<tbody>").html(str + '</tbody>')
                            );
                    }
                }
}
                latestpos = pos;
                savedata();
                 sorttrigger();
                 resetSelects();
                 new Tablesort(document.getElementById('dynamicrows'));
            }

 function guid() {
                    function s4() {
                            return Math.floor((1 + Math.random()) * 0x10000)
                            .toString(16)
                            .substring(1);
                    }
                    
                    return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
            }

    var brandArray;
    var typeArray;
    var materialArray;
    var brandListArray = [];
    var typeListArray = [];
    var materialListArray = [];

$(function() { 
    sorttrigger();
    $('#bat_nr').fdatepicker({
    format: 'dd-mm-yyyy',
    disableDblClickSelection: true
  });


});

function fillBrands() {
    //$.get( "<?php echo url('data/blus/brands') ?>", function( data ) {
    console.log(brandListArray);
    $("#type").select2();
    $("#material").select2();
    $('#brand').select2({ 
        data:brandListArray,
        createSearchChoice:function(term, data) { 
        if ($(data).filter(function() { 
            return this.text.localeCompare(term)===0; 
        }).length===0) 
        {return {id:term, text:term};} 
    },
    multiple: false,
    tags: true,
    selectOnBlur: true
    });
    
   // $('#brand').trigger("select2:select");

//});
}

function fillMaterials(typeid) {
    $("#material").html('').trigger('change');
   
    try {
    var texttype = $('#type').select2('data')[0]['text'];

    if (texttype == 'Water') {
        $('#last_sealed').attr('disabled',false);
        $('#debiet_measure').attr('disabled',false);
      }
    else {
        $('#last_sealed').attr('disabled',true);
        $('#debiet_measure').attr('disabled',true);
        $('#last_sealed').val(0);
        $('#debiet_measure').val('');
    }
    } catch (err) { //ini problem no catch needed.
    }
   
    //var url = '<?php echo url('data/blus/material') ?>' + '/'+typeid;
    // $.get(url, function( data ) {
     findMaterial(typeid);
     $("#material").select2(
        {
            data:materialListArray,createSearchChoice:function(term, data) { 
        if ($(data).filter(function() { 
            return this.text.localeCompare(term)===0; 
        }).length===0) 
        {return {id:term, text:term};} 
        },
    multiple: false,
    tags: true,
    selectOnBlur: true
    });

    //});

}



function sorttrigger() {
    var f_sl = 1; //-1 is reverse
    var n = $("#sl").prevAll().length;
    sortTable(f_sl,n);
}


$('#ready').click(function(e){
   saveReady();

});

$('#addkenmerk').click(function(e) {

    console.log('Saving kenmerk' + $('#kenmerk').val());
let k = $('#kenmerk').val();
     let data = {reportid: {{$report->id}},kenmerk: k};
console.log(data);


$.ajax({
    type: "POST",
    url: '/kenmerk',
    data: { reportid: {{$report->id}},kenmerk: k, _token: '{{csrf_token()}}' },
    success: function (data) {
       console.log(data);
    },
    error: function (data, textStatus, errorThrown) {
        console.log(data);

    },
});



});

function saveReady() {
     if (!offline) {
        //only save to server if not offline

        if ($('#ready').prop('checked') == true) {
        inputd = 1;
        }
        else {
            inputd = 0;
        }
       console.log(inputd);
        $.ajax( {
            type: 'POST', 
            url:"<?php echo url('/customer/saveready') ?>",
            data: {inputdata:inputd,category: 'noodverlichting',user_id:<?php echo \Auth::user()->id;?>, customer_id: <?php echo $customer->id; ?>,location_id: <?php echo $location->id; ?>,report_id: <?php echo $report->id; ?>},
            success: function( data ){
          
            console.log('saved ready'  +data);
         },
         error: function (data) {
            console.log('fout' + data);
            saveReady();
         } 
        });
    }
    else {
        //TODO save ready to local storage. .. .disable back to overview
    }
}

function savedata() {
    if (!offline) {
        //only save to server if not offline

    for(var i = 0; i < localStorage.length; i++) {
            var key = localStorage.key(i);
            if(key.indexOf(prefix) == 0) {
                var getitem = localStorage.getItem(key); 
        }
    }
       
        $.ajax( {
            type: 'POST', 
            url:"<?php echo url('/customer/savereport') ?>",
            data: {inputdata:getitem,category: 'noodverlichting',user_id:<?php echo \Auth::user()->id;?>, customer_id: <?php echo $customer->id; ?>,location_id: <?php echo $location->id; ?>,report_id: <?php echo $report->id; ?>},
            success: function( data ){
          
            console.log('saved');
         },
         error: function (data) {
            console.log('fout' + data);
            savedata();
         } 
        });
    }
}

function log(data) {
/*     
      $.ajax( {
            type: 'POST', 
            url:"<?php echo url('/report/log') ?>",
            data: {inputdata:JSON.stringify(data),category: 'noodverlichting',user_id:<?php echo \Auth::user()->id;?>, customer_id: <?php echo $customer->id; ?>,location_id: <?php echo $location->id; ?>,report_id: <?php echo $report->id; ?>},
            success: function( data ){
          
            console.log('saved ready'  +data);
         },
         error: function (data) {
            console.log('fout' + data);
            saveReady();
         } 
        });
*/
    }

</script>

@endsection