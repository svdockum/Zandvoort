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
         <?php 

         if ($report->locked == 0)  { 
                  ?>
                  <div class="row">
            <div class="small-12 medium-1 columns">
                  <a href="{{url()->current() . '/checkin'}}" class="button @if ($type == 'blusmiddelen') bgred @endif @if ($type == 'keerkleppen') blue @endif @if ($type == 'noodverlichting') bggreen @endif" id="checkin" data-key="" style="margin-top:15px;">Inchecken</a>
                </div>
                </div>
                  <?php 


                }
else if ($report->locked == \Auth::user()->id) {
                  ?>
<div id="messagelocked" style="color:red;font-weight: bold;">Let op: Open dit rapport niet op een ander tabblad of andere ipad/pc. Eerst Uitchecken!</div>

       
<div class="row">
            <div class="small-12 medium-1 columns" style="padding-right:0px;">

                        <label for="pos">Volgnr.</label>
                        <input type="text" id="pos" name="pos" value="" />
            </div>
            <div class="small-12 medium-2 columns" >
                         <label for="pos">Verdieping</label>
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
                         <label for="pos">Type verlichting</label>
                        <select id="picto" name="picto" class="s2">
                            <option selected>Led</option>
                            <option>TL</option>
                   
                        </select>
            </div>
            <div class="small-12 medium-3 columns">
            
                <div class="row">
                   
                    <div class="small-12 medium-4 columns">
                    <label for="pos">Watt</label>
                        <input type="number" id="watt" name="watt" style="width:70px;"/>
                    </div>
                </div>     
            </div>
        </div>

        <div class="row">
                   <div class="medium-3 columns">
                                                
                        <label for="arm_merk">Merk</label>
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
                        <label for="ty">Armatuur type</label>
                        <input type="text" name="ty" id="ty"> 
                        <label for="arm_type">Accu Type</label>
                        <select id="arm_type" name="arm_type" class="s2">
                            
                           
                            <!--
                            @foreach (\App\Type::where('category','=','armatuur')->get() as $brand)
                            
                              <option>{{ $brand->name }}</option>
                            
                            @endforeach
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
                       <label for="fabaccu">Fabricagejaar Accu</label>
                        <!-- <input type="number" id="fabaccu" name="fabaccu" style="margin-bottom:0px;" />-->
                         <select id="fabaccu" name="fabaccu" class="s2">
                         <?php 
                         $curyear = date("Y"); 
                         
                         for ($i = $curyear;$i>=($curyear-5);$i--) {
                            echo "<option value=\"" . $i . "\">" . $i . "</option>";
                            
                         }
                         
                         
                         ?>

                   </select>
                       
                    </div> 
                    <div class="medium-3 columns">
                    <label for="arm_nr">Accusoort</label>
                         <input type="text" id="arm_nr" name="arm_nr" style="margin-bottom:0px;" />
                    <div class="row">
                            <div class="medium-3 columns">
                    <label for="pos">Volt</label>
                        <input type="number" step="0.1" id="volt" name="volt" style="width:70px;" />
                   </div>
                   <div class="medium-3 columns end">
                    <label for="pos">Amp</label>
                        <input type="number" step="0.1" id="amp" name="amp" style="width:70px;"/>
                    </div>
                    </div>
                      
                    </div>
                    <div class="medium-3 columns">
                        <div style="display:inline-block;" class="text-center"> 
                            <label for="permanent">Permanent</label>
                            <div class="switch large">
                                <input class="switch-input" id="permanent" type="checkbox" name="permanent" value="Ja" checked>
                                <label class="switch-paddle @if ($type == 'blusmiddelen') bgred @endif @if ($type == 'keerkleppen') blue @endif @if ($type == 'noodverlichting') bggreen @endif @if ($type == 'noodverlichting2') bggreen @endif" for="permanent">
                                <span class="switch-active" aria-hidden="true" style="left: 20%;">Ja</span>
                                <span class="switch-inactive" aria-hidden="true" style="right: 10%;">Nee</span>
                                </label>
                                </div>
                        </div>
                        <div style="display:inline-block;" class="text-center"> 
                   <label for="ok">Goedgekeurd?</label>
                    <div class="switch large">
                    <input class="switch-input" id="ok" type="checkbox" name="ok" value="Ja" checked>
                    <label class="switch-paddle @if ($type == 'blusmiddelen') bgred @endif @if ($type == 'keerkleppen') blue @endif @if ($type == 'noodverlichting') bggreen @endif @if ($type == 'noodverlichting2') bggreen @endif" for="ok">
                      <span class="switch-active" aria-hidden="true" style="left: 20%;">Ja</span>
                      <span class="switch-inactive" aria-hidden="true" style="right: 10%;">Nee</span>
                    </label>
                  </div>
                </div>
                   </div>
                   <div class="medium-3 columns">
                       
                    </div>
        
        </div>
        <div class="row">
       
           <div class="small-12 columns text-left">
            
               <label for="pos">Opmerkingen</label>
                       <input type="text" id="remarks" name="remarks" />
            </div>
            
         </div>
           
     
       

        <div class="row">
              <div class="small-12 medium-8 columns">
              <label for="notes">Eigen opmerkingen (niet op rapport)</label>
              <textarea id="notes" name="notes"></textarea>
              </div>
              <div class="small-12 medium-4 columns align-middle text-center">
        
              <a href="#" class="button large @if ($type == 'blusmiddelen') bgred @endif @if ($type == 'keerkleppen') blue @endif @if ($type == 'noodverlichting') bggreen @endif" id="addrow" data-key="" style="margin-top:15px;">Invoeren</a>
        <a href="{{url()->current() . '/checkout'}}" class="offlinedisable button @if ($type == 'blusmiddelen') bgred @endif @if ($type == 'keerkleppen') blue @endif @if ($type == 'noodverlichting') bggreen @endif" id="checkout" data-key="" style="margin-top:15px;">Uitchecken</a>
        
        
              </div>
            </div>


     
<?php }
else {

  $user = \App\User::find($report->locked);

  echo '<strong>' . $user->name . '</strong> heeft dit rapport in gebruik. Je kan niets aanpassen.';
  ?>
  <a href="{{url()->current() . '/checkout'}}" class="offlinedisable button @if ($type == 'blusmiddelen') bgred @endif @if ($type == 'keerkleppen') blue @endif @if ($type == 'noodverlichting') bggreen @endif" id="checkout" data-key="" style="margin-top:15px;">Forceer Uitchecken</a>
  <br>
 Laatste opslag datum: {{$report->updated_at->format('d-m-Y | h:i')}} 
  <?php
}

 ?>
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
}

    keyvals = {};
    
    $('input,select,textarea').each(function(){
    

if ($(this).attr('id') != 'ready') {
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
})


        keyvals['remarks'] =  $('#remarks').val();
        data['row'+guid()] = keyvals ;
        localStorage.setItem(prefix,JSON.stringify(data));
if (!offline) log(data);
        RewriteFromStorage();
});


$('body').on('click', 'a.editbtn', function(event) {
    event.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, "slow");
    $('#addrow').html('Aanpassen');
    $('#addrow').data('key',$(this).data('key'));

    console.log($(this).data('key'));
    //load all from row
    var row = data[$(this).data('key')];
     Object.keys(row).forEach(function(nkey,index) {
       // console.log(nkey);

         if (nkey.indexOf('_merk') >= 0
              || nkey.indexOf('_type') >= 0
               || nkey.indexOf('etage') >= 0
               || nkey.indexOf('fabaccu') >= 0
            
                || nkey.indexOf('picto') >= 0
             

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
                                      || nkey.indexOf('permanent') >= 0
                                      || nkey.indexOf('ok') >= 0) 
                                      {
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


    $('#arm_type').on("select2:select", function (e) { 
        $('#arm_nr').val(jsonAccu[$('#arm_type').val()][0].Soort);
        $('#volt').val(jsonAccu[$('#arm_type').val()][0].volt.replace(',','.'));
        $('#amp').val(jsonAccu[$('#arm_type').val()][0].amp.replace(',','.'));
   
    });


    $('#picto').on("select2:select", function (e) { 
        $('#watt').val(jsonLicht[$('#picto').val()][0].watt);
        
    });


//FUNCTIONS
function resetSelects() {
    //$("select").selectedIndex = 0
    //$('select').find("select option:eq(0)").prop("selected", true).trigger('change');
    $('select').val('-').trigger('change');
    $('input:text').val('');
    $('input[type="number"]').val('');
    $('input:checkbox').not("#ready").prop('checked',true);

    $('#etage').val('B.G.').trigger('change');;
    $('#pos').val(latestpos);
    $('#notes').val('');
    
    
  
   
}

            function RewriteFromStorage() {
                pos = 1;
             

                    $("#dynamicrows").html('<thead> <tr> <th style="width:80px" id="sl" data-sort-order="asc" class="sort-default" data-sort-method="number">Volgnr.</th><th>Locatie</th><th>Lichttype</th> <th>Watt</th> <th>Merk/Type/Accu</th><th>Fab. Jaar</th><th>Soort</th><th>Volt</th><th>Amp</th><th>Permanent</th><th>Goedgekeurd</th><th>Opmerkingen</th> <th class="text-center">Aanpassen</th><th class="text-center">Verwijderen</th> </tr></thead>');
                    

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

                                    if (nkey != 'notes') {
                                      
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
                                     // || nkey.indexOf('ok') >= 0
                                      ) {

                                      if (customer_rows[key][nkey] == 0) {
                                         str += '<br>Nee';
                                      }
                                      else {
                                        str += '<br>' + customer_rows[key][nkey];
                                      }

                                    }
                                    else if (nkey.indexOf('_type') >= 0 || nkey.indexOf('ty') >= 0) {
                                        str += '<br>' + customer_rows[key][nkey];
                                    }
                                    else {
                                      if ((nkey == 'ok' && customer_rows[key][nkey] == 0) || (nkey == 'permanent' && customer_rows[key][nkey] == 0))  {
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
                                if ($type == 'blusmiddelen') $extraclass = 'bgred'; 
                                if ($type == 'keerkleppen') $extraclass = 'blue' ;
                                if ($type == 'noodverlichting') $extraclass = 'bggreen';
                                ?>
                                str += '</td><td class="text-center"><a <?php if ($report->locked == 0 || $report->locked != \Auth::user()->id)  { echo 'style="display:none;"'; }?> class="editbtn button <?php echo $extraclass; ?> " href="#" data-key="'+key+'"><i class="fa fa-pencil-square-o"></i></a></td><td class="text-center"><a <?php if ($report->locked == 0 || $report->locked != \Auth::user()->id)  { echo 'style="display:none;"'; }?> class="deletebtn button <?php echo $extraclass; ?>" href="#" data-key="'+key+'"><i class="fa fa-trash-o"></i></a></td>';
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
   
    loadAccuTypes();
    loadLichtTypes();
     
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
}

var jsonAccu;

function loadAccuTypes() {
    
let dropdown = document.getElementById('arm_type');
dropdown.length = 0;

let defaultOption = document.createElement('option');
defaultOption.text = '-';

dropdown.add(defaultOption);
dropdown.selectedIndex = 0;

const url = '//' + window.location.hostname + '/js/accu.json';



 fetch(url)  
   .then(  
     function(response) {  
       if (response.status !== 200) {  
         console.warn('Looks like there was a problem. Status Code: ' + 
           response.status);  
         return;  
       }

       // Examine the text in the response  
       response.json().then(function(data) {  
        //   console.log(data);
         jsonAccu = data;
         let option;
    
         Object.keys(data).forEach(function(key) {
        //console.table('Key : ' + key + ', Value : ' + data[key])
          option = document.createElement('option');
       	  option.text = key;
       	  option.value = key;
       	  dropdown.add(option);

})

     	// for (let i = 0; i < data.length; i++) {
        //    option = document.createElement('option');
       	//   option.text = data[i].name;
       	//   option.value = data[i].abbreviation;
       	//   dropdown.add(option);
     	// }    
       });  
     }  
   )  
   .catch(function(err) {  
     console.error('Fetch Error -', err);  
   });

}


var jsonLicht;

function loadLichtTypes() {
    
let dropdown = document.getElementById('picto');
dropdown.length = 0;

let defaultOption = document.createElement('option');
defaultOption.text = '-';

dropdown.add(defaultOption);
dropdown.selectedIndex = 0;

const url = '//' + window.location.hostname + '/js/licht.json';



 fetch(url)  
   .then(  
     function(response) {  
       if (response.status !== 200) {  
         console.warn('Looks like there was a problem. Status Code: ' + 
           response.status);  
         return;  
       }

       // Examine the text in the response  
       response.json().then(function(data) {  
       //    console.log(data);
         jsonLicht = data;
         let option;
    
         Object.keys(data).forEach(function(key) {
        //console.table('Key : ' + key + ', Value : ' + data[key])
          option = document.createElement('option');
       	  option.text = key;
       	  option.value = key;
       	  dropdown.add(option);

})

     	// for (let i = 0; i < data.length; i++) {
        //    option = document.createElement('option');
       	//   option.text = data[i].name;
       	//   option.value = data[i].abbreviation;
       	//   dropdown.add(option);
     	// }    
       });  
     }  
   )  
   .catch(function(err) {  
     console.error('Fetch Error -', err);  
   });

}


</script>

@endsection