@extends('layouts.app')
@section('content')

<div class="row " style="margin-bottom: 2rem;">
    <div class="small-12 columns">
        <div class="row">
            <div class="small-3 columns text-center">
                @if (empty($customer->logo))
                                       <img style="height: 100px;" src="https://placehold.it/250x100/eeeeee?text=Geen logo" />
                                   @else 
                                    <img style="height: 100px;" src="{{ url('/customerlogos/'. $customer->id . '/' . $customer->logo)}}" />
                                    @endif
            </div>
            <div class="small-6 columns align-middle">
                <h4>{{$customer->name}}</h4>
                <small>{{$location->name}} {{$location->street}} {{$location->housenumber}},<br> {{$location->postalcode}}, {{$location->city}}<br><!--<a href="#">Aanpassen</a>--></small>
               <a href="{{url('/report/'.$report->id.'/selectlocation')}}" id="changeloc" class="offlinedisable">Locatie aanpassen</a>

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
        </div>
</div>

<div id="message" style="color:red;font-weight: bold;"></div>
       

        <div class="row">
            <div class="small-12 columns">
                <div class="row ">
                    <div class="medium-4 columns">
                        <label for="pos">Pos.</label>
                        <input type="text" id="pos" name="pos" value="" />
                         <label for="pos">Locatie</label>
                        <input type="text" id="location" name="location" />
                         <label for="pos">Opmerkingen</label>
                        <input type="text" id="remarks" name="remarks" />
                    </div>
                    <div class="medium-4 columns">
                        
                        <label for="pos">Merk</label>
                        <select id="brand" name="brand" class="s2"/>
                            <option value="0">-</option>
                        </select>
                        
                        <label for="type" style="margin-top: 1rem;">Blusstof</label>
                        <select id="type" name="type" class="s2">
                            <option>-</option>
                        </select>
                        
                        <label for="pos" style="margin-top: 1rem;">Type</label>
                        <select id="material" name="material" class="s2">
                            <option>-</option>
                        </select>
                       
                    </div> 
                    <div class="medium-4 columns">
                        <label for="pos">Fabricatie Jaar</label>
                            <select id="fabrication_year" name="fabrication_year">
                            <?php 
                                
                                $start = date('Y');
                                echo $start;
                                for ($i = $start;$i > $start-40;$i--) {
                                  echo '<option>'.$i.'</option>';
                                  
                                } ?>
                               
                            </select>
                        <label for="pos" style="margin-top: 1rem;">Laatst Afgeperst in:</label>
                            <select id="last_sealed" name="last_sealed" >
                                <option value="0"></option>
                                <?php 
                                
                                $start = date('Y');
                                echo $start;
                                for ($i = $start;$i > $start-10;$i--) {
                                  echo '<option>'.$i.'</option>';
                                  
                                } ?>
                            </select>
                        <label for="pos">Debiet </label>
                            <input type="number" id="debiet_measure" name="debiet_measure" placeholder="(l/min)"  />
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="medium-4 medium-offset-4 columns text-center">
                <label for="yes_no">Goedgekeurd</label>
                    <div class="switch large">
                    <input class="switch-input" id="yes_no" type="checkbox" name="exampleSwitch" value="Ja" checked>
                    <label class="switch-paddle @if ($type == 'blusmiddelen') bgred @endif @if ($type == 'keerkleppen') blue @endif @if ($type == 'noodverlichting') bggreen @endif" for="yes_no">
                      <span class="switch-active" aria-hidden="true" style="left: 20%;">Ja</span>
                      <span class="switch-inactive" aria-hidden="true" style="right: 10%;">Nee</span>
                    </label>
                  </div>
     
            </div>
            <div class="small-4 columns align-middle text-center">
                <a href="#" class="button large @if ($type == 'blusmiddelen') bgred @endif @if ($type == 'keerkleppen') blue @endif @if ($type == 'noodverlichting') bggreen @endif" id="addrow" data-key="" style="margin-top:15px;">Invoeren</a>
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



localStorage.setItem(prefix,<?php echo "'" . $report->json . "'"; ?>);

//load initial values
RewriteFromStorage();



$('#fabrication_year').select2({ 
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
            

            keyvals[ $(this).attr('id')] = textvalue;
            console.log($(this).select2('data')[0]['text']);
            }catch (error) {
                keyvals[ $(this).attr('id')] = "-"; //no text filled in
            }
        }
        else if ( typeof $(this).attr('id') != 'undefined'){
                keyvals[ $(this).attr('id')] =  $(this).val();
        }

        }
    }
})


        keyvals['remarks'] =  $('#remarks').val();
        data['row'+guid()] = keyvals ;
        localStorage.setItem(prefix,JSON.stringify(data));

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

         if (nkey == 'brand' || nkey == 'type' || nkey == 'material' || nkey == 'fabrication_year') {
              //$('#'+nkey).select2('text',row[nkey]);
              
              $("#"+nkey+ ' option').removeAttr("selected").trigger('change');
              //check of hij bestaat
              if ($("#"+nkey +" option:contains('"+row[nkey]+"')").length > 0) {
                
                $("#"+nkey+ ' option').each(function () { 
                if ($(this).html() == row[nkey]) {
                   
                        $(this).prop("selected", "selected");
                        return;
                    }
                });
                $("#"+nkey).trigger('change');
              }
              else {

              $('#'+nkey).append('<option selected value="'+row[nkey]+'">'+row[nkey]+'</option>').val(row[nkey]).trigger('change');        
              }
        
         }
         else if (nkey == 'yes_no') {
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

    //  try { //disable debiet 
    // var texttype = $('#type').select2('data')[0]['text'];

    // if (texttype == 'Water') {
    //     $('#last_sealed').attr('disabled',false);
    //     $('#debiet_measure').attr('disabled',false);
    //   }
    // else {
    //     $('#last_sealed').attr('disabled',true);
    //     $('#debiet_measure').attr('disabled',true);
    //     $('#last_sealed').val(0);
    //     $('#debiet_measure').val('');
    // }
    // } catch (err) { //ini problem no catch needed.
    // }

});


$('body').on('click', 'a.deletebtn', function(event) {

    event.preventDefault();
   
var txt;
var r = confirm("Weet je zeker dat je deze regel wil verwijderen?");
if (r == true) {
    delete data[$(this).data('key')];
    console.log($(this).data('key'));
    localStorage.setItem(prefix,JSON.stringify(data));
    RewriteFromStorage();

} 


  
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
    $("#type").html('').trigger('change');
    $("#material").html('').trigger('change');
    $("#brand").html('').append('<option selected="selected" value="-">-</option>').trigger('change');

    $('#location').val('');
    $('#remarks').val('');
    $('#yes_no').prop('checked',true);

    $("#fabrication_year").val($("#fabrication_year option:first").val());
    // $('#last_sealed').attr('disabled',true);
    // $('#debiet_measure').attr('disabled',true);
    // $('#last_sealed').val(0);
    // $('#debiet_measure').val('');

    fillBrands();
   
}

            function RewriteFromStorage() {
                pos = 1;
             

                    $("#dynamicrows").html('<thead> <tr> <th id="sl">Pos.</th> <th>Locatie</th> <th>Merk</th> <th>Blusstof</th> <th>Type</th> <th>Fab. Jaar</th> <th>Afgeperst</th><td>Debiet (l/min)</th> <th class="td_yes_no"> Goedgekeurd </th> <th>Opmerkingen</th> <th class="text-center">Aanpassen</th><th class="text-center">Verwijderen</th> </tr></thead>');
                    

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
                                    if (nkey == 'yes_no' && (customer_rows[key][nkey] == 0 || customer_rows[key][nkey] == '')) {
                                       str += '<td class="td_' + nkey +'">Nee</td>';
                                    }
                                    else  if (nkey == 'yes-no' && (customer_rows[key][nkey] == 0 || customer_rows[key][nkey] == '')) {
                                       str += '<td class="td_' + nkey +'">Nee</td>';
                                    }
                                    else{
                                        $value = customer_rows[key][nkey];
                                        if ($value == 0) { $value = '-';}
                                     str += '<td class="td_' + nkey +'">'+ $value +'</td>';
                                    }

                                    //set global data
                                    data[datarow_guid] = keyvals ;
                                    //set latest position
                                    pos = parseInt(customer_rows[key]['pos']) + 1;
                                });
                                   
                                <?php
                                if ($type == 'blusmiddelen') $extraclass = 'bgred'; 
                                if ($type == 'keerkleppen') $extraclass = 'blue' ;
                                if ($type == 'noodverlichting') $extraclass = 'bggreen';
                                ?>
                                str += '<td class="text-center"><a class="editbtn button <?php echo $extraclass; ?> " href="#" data-key="'+key+'"><i class="fa fa-pencil-square-o"></i></a></td><td class="text-center"><a class="deletebtn button <?php echo $extraclass; ?>" href="#" data-key="'+key+'"><i class="fa fa-trash-o"></i></a></td>';
                                str += '</tr>';
                                
                        });

                        $("#dynamicrows").append(
                                $("<tbody>").html(str + '</tbody>')
                            );
                    }
                }
            }
                $('#pos').val(pos);
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
   
    loaddropdownData();
     
    sorttrigger();

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
}

function loaddropdownData() {

 var url = '<?php echo url('data/blus/brands') ?>';
     $.get(url, function( data ) {
        brandArray = data;
         var result = $.grep(data, function(element, index) {
            brandListArray.push({id:element.id,text:element.text});
            
        });

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
         // console.log(brandListArray);
         //   console.log(data);
     });

 var url = '<?php echo url('data/blus/type') ?>';
     $.get(url, function( data ) {
        typeArray = data;
      //  console.log(data);
     });

    var url = '<?php echo url('data/blus/material') ?>';
     $.get(url, function( data ) {
        materialArray = data;
       // console.log(data);
     });

}




function findTypes(brandid) {
typeListArray = [];
    var result = $.grep(typeArray, function(element, index) {
        if (element.brand_id == brandid) {
            typeListArray.push({id:element.id,text:element.name});
        }
    });


}

function findMaterial(typeid) {
materialListArray = [];
    var result = $.grep(materialArray, function(element, index) {
        if (element.type_id == typeid) {
            materialListArray.push({id:element.id,text:element.name});
        }
    });

}

</script>

@endsection