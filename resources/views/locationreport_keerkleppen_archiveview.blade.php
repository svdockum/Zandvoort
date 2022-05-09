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
             <a class="" href="{{ url('/report/pdf/' . $report->id) }}" target="_blank">PDF</a>
                   
                   
            </div>
            <div class="small-3 columns align-middle text-right offlinedisable">
                <a href="{{ url('/customer/'. $customer->id)}}" class="button @if ($type == 'blusmiddelen') bgred @endif @if ($type == 'keerkleppen') blue @endif @if ($type == 'noodverlichting') bggreen @endif"><i class="fa fa-btn fa fa-caret-left"></i>Terug naar Overzicht</a>
              
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

<?php if ($report->locked == 0 || $report->locked != \Auth::user()->id) { ?>
  localStorage.setItem(prefix,<?php echo "'" . $report->json . "'"; ?>);
<?php } ?>

//load initial values
RewriteFromStorage();

$('#fixednotes').on('change',function(){
    var selected = $(this).find(":selected").val();
    if (selected == '-') {
        $('#remarks').val('');
        $('#remarks').attr('readonly',false);
      
    }
    else {
        $('#remarks').attr('readonly',true);
        $('#remarks').val(selected);  
    }
 
});

$('#etage,#brand,#type,#fabrication_year,#diameter').select2({ 
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
    
    $('input,select').each(function(){
    

if ($(this).attr('id') != 'ready') {
    if ($(this).attr('id') != 'remarks') {
       if ($(this).attr('id') != 'fixednotes') {
        
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
            }catch (error) {
                keyvals[ $(this).attr('id')] = "-"; //no text filled in
            }
        }
        else if ( typeof $(this).attr('id') != 'undefined'){
                keyvals[ $(this).attr('id')] = escapeHtml($(this).val());
        }

        }
    }
  }
})


        keyvals['remarks'] =  $('#remarks').val();
        data['row'+guid()] = keyvals ;
        localStorage.setItem(prefix,JSON.stringify(data));

 var time = (new Date ((new Date((new Date(new Date())).toISOString() )).getTime() - ((new Date()).getTimezoneOffset()*60000))).toISOString().slice(0, 19).replace('T', ' ');
                localStorage.setItem(dateprefix,String(time));

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

         if (nkey == 'brand' || nkey == 'type' || nkey == 'diameter'|| nkey == 'etage' || nkey == 'fabrication_year') {
              //$('#'+nkey).select2('text',row[nkey]);
              
              $("#"+nkey+ ' option').removeAttr("selected").trigger('change');
              //check of hij bestaat
              if ($("#"+nkey +" option:contains('"+row[nkey]+"')").length > 0) {
                
                $("#"+nkey+ ' option').each(function () { 
                if ($(this).html() == row[nkey]) {
                   
                        $(this).prop("selected", "selected");
                 }
                });
                $("#"+nkey).trigger('change');
              }
              else {

              $('#'+nkey).append('<option selected value="'+row[nkey]+'">'+row[nkey]+'</option>').val(row[nkey]).trigger('change');        
              }
        
         }
         else if (nkey == 'yes-no' || nkey == 'drukvast') {
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

     var time = (new Date ((new Date((new Date(new Date())).toISOString() )).getTime() - ((new Date()).getTimezoneOffset()*60000))).toISOString().slice(0, 19).replace('T', ' ');
                localStorage.setItem(dateprefix,String(time));
});


$('body').on('click', 'a.deletebtn', function(event) {
    event.preventDefault();
    delete data[$(this).data('key')];
    console.log($(this).data('key'));
    localStorage.setItem(prefix,JSON.stringify(data));
     var time = (new Date ((new Date((new Date(new Date())).toISOString() )).getTime() - ((new Date()).getTimezoneOffset()*60000))).toISOString().slice(0, 19).replace('T', ' ');
                localStorage.setItem(dateprefix,String(time));

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

$(window).bind('beforeunload', function(e) { 
    if (offline) {
    return "Waarschuwing, je bent offline. Als je de pagina vernieuwd kan je niet meer verder totdat je weer internet hebt."
    e.preventDefault();
    }
});
// END Register listeners
/////////////////////////////////////////////////////////////


// Triggers
/////////////////////////////////////////////////////////////

 


//FUNCTIONS
function resetSelects() {
     $('#remarks').attr('readonly',false);
    $("#brand").val('-').trigger('change');
    $("#type").val('-').trigger('change');
    $("#fabrication_year").val('-').trigger('change');
    $("#diameter").val('-').trigger('change');

    $('#location').val('');
    //$('#etage').val('-').trigger('change');
    $('#remarks').val('');
    $('#yes-no').prop('checked',true);
    $('#drukvast').prop('checked',true);

//    $("#fabrication_year").val($("#fabrication_year option:first").val()).trigger('change');
  //  $("#diameter").val($("#diameter option:first").val()).trigger('change');

    $('#last_sealed').attr('disabled',true);
    $('#debiet_measure').attr('disabled',true);
    $('#last_sealed').val(0);
    $('#debiet_measure').val('');

    $('#result').val('');
   
}

            function RewriteFromStorage() {
                pos = 1;
             

                    $("#dynamicrows").html('<thead> <tr> <th id="sl" data-sort-order="asc" class="sort-default" data-sort-method="number">Pos.</th><th>Etage</th> <th>Ruimte</th> <th>Toestel</th> <th>Huidig</th> <th>Plaats beveiliging</th> <th>Fitting</th> <th>Diameter</th><th>Drukvast</th> <th class="td_yes-no"> Goedgekeurd </th> <th>Opmerkingen</th> </tr></thead>');
                    

                    for(var i = 0; i < localStorage.length; i++) {
                            
                        var key = localStorage.key(i);


                        if(key.indexOf(prefix) == 0) {
                                    
                            var getitem = localStorage.getItem(key); 
                          
                              
                            //set global data
                          if (getitem != '') {
                           customer_rows = JSON.parse(getitem);
                           // data=customer_rows = getitem;
                            var str = '';
            
                            Object.keys(customer_rows).forEach(function(key,index) {
                                  var datarow_guid = key;
                                  keyvals = {};

                                str += '<tr>';
                                            
                                Object.keys(customer_rows[key]).forEach(function(nkey,index) {
                                    keyvals[nkey] = customer_rows[key][nkey];
                                    if (nkey == 'yes-no' && customer_rows[key][nkey] == 0) {
                                       str += '<td class="tdred td_' + nkey +'">Nee</td>';
                                    }
                                    else if (nkey == 'drukvast' && customer_rows[key][nkey] == 0) {
                                       str += '<td class="tdred td_' + nkey +'">Nee</td>';
                                    }
                                    else if (nkey == 'last_sealed' ) {
                                        if (customer_rows[key][nkey] > 0) {
                                        str += '<td>'+ customer_rows[key][nkey] +' / ';
                                        }
                                        else {
                                        str += '<td> - / ';
                                            
                                        }
                                    }
                                    else if (nkey == 'debiet_measure' ){
                                        if (customer_rows[key][nkey] > 0) {
                                           str += customer_rows[key][nkey] +'</td>';
                                        }
                                        else {
                                            str += ' -</td>';
                                        }
                                    }
                                    else {
                                     str += '<td class="td_' + nkey +'">'+ customer_rows[key][nkey] +'</td>';
                                    }

                                    //set global data
                                    data[datarow_guid] = keyvals ;
                                    //set latest position
                                    pos = parseInt(customer_rows[key]['pos']) + 1;
                                });
                                   
                                <?php
                                if ($type == 'blusmiddelen') $extraclass = 'bgred'; 
                                if ($type == 'keerkleppen') $extraclass = 'blue' ;
                                if ($type == 'noodverlichtng') $extraclass = 'bggreen';
                                ?>
                               str += '</td>';
                                str += '</tr>';
                                
                        });

                        $("#dynamicrows").append(
                                $("<tbody>").html(str + '</tbody>')
                            );
                    }
                }

                $('#pos').val(pos);
              }
               // savedata();
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

});


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
            data: {inputdata:inputd,category: 'blusmiddelen',user_id:<?php echo \Auth::user()->id;?>, customer_id: <?php echo $customer->id; ?>,location_id: <?php echo $location->id; ?>,report_id: <?php echo $report->id; ?>},
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
    <?php if ($report->locked == \Auth::user()->id)  { ?>
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
            data: {inputdata:getitem,category: 'blusmiddelen',user_id:<?php echo \Auth::user()->id;?>, customer_id: <?php echo $customer->id; ?>,location_id: <?php echo $location->id; ?>,report_id: <?php echo $report->id; ?>},
            success: function( data ){
          
            console.log('saved');
         },
         error: function (data) {
            console.log('fout' + data);
            savedata();
         } 
        });
    }
      <?php } ?>
}

function log(data) {
     
      $.ajax( {
            type: 'POST', 
            url:"<?php echo url('/report/log') ?>",
            data: {inputdata:JSON.stringify(data),category: 'keerkleppen',user_id:<?php echo \Auth::user()->id;?>, customer_id: <?php echo $customer->id; ?>,location_id: <?php echo $location->id; ?>,report_id: <?php echo $report->id; ?>},
            success: function( data ){
          
            console.log('saved ready'  +data);
         },
         error: function (data) {
            console.log('fout' + data);
            saveReady();
         } 
        });
}



</script>

@endsection