@extends('layouts.app')
@section('content')




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
var entry = <?php echo $entry->id;?>;

var branddata;
var typedata;
var blusstof;

var prefix = uniquekey + entry + '-';
var dateprefix = uniquekey + '-date-'+ entry;

var data ={};
var tkeyvals = {};


localStorage.setItem(prefix,<?php echo "'" . $entry->json . "'"; ?>);

//load initial values
RewriteFromStorage();


     



            function RewriteFromStorage() {
                pos = 1;
             

                    $("#dynamicrows").html('<thead> <tr> <th id="sl" data-sort-order="asc" class="sort-default" data-sort-method="number">Pos.</th><th>Etage</th> <th>Locatie</th> <th>Merk</th> <th>Blusstof</th> <th>Type</th> <th>Fab. Jaar</th> <th>Afgeperst</th><td>Debiet (l/min)</th> <th class="td_yes_no" style="text-align:center"> Goedgekeurd </th> <th>Opmerkingen</th></tr></thead>');
                    

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
                                       str += '<td style="text-align:center" class="tdred td_' + nkey +'">Nee</td>';
                                    }
                                    else  if (nkey == 'yes-no' && (customer_rows[key][nkey] == 0 || customer_rows[key][nkey] == '')) {
                                       str += '<td style="text-align:center" class="tdred td_' + nkey +'">Nee</td>';
                                    }
                                    else{
                                        $value = customer_rows[key][nkey];
                                        if ($value == 0) { $value = '-';}
                                     str += '<td style="text-align:center" class="td_' + nkey +'">'+ $value +'</td>';
                                    }

                                    //set global data
                                    data[datarow_guid] = keyvals ;
                                    //set latest position
                                    pos = parseInt(customer_rows[key]['pos']) + 1;
                                });
                                   
                                str += '</td>';
                                str += '</tr>';
                                
                        });

                        $("#dynamicrows").append(
                                $("<tbody>").html(str + '</tbody>')
                            );
                    }
                }
            }
                 var sort = new Tablesort(document.getElementById('dynamicrows'));
                 sort.refresh();
                 //sorttrigger();
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
    console.log('sort');
    sortTable(f_sl,n);
}



</script>

@endsection