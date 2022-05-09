<?php 


$count = $counteuro = 0;
$row = 1;
$avgrow = 0;
if (($handle = fopen("../storage/post.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        //echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        //for ($c=0; $c < $num; $c++) {
        $eur = strpos(strtolower($data[3]), 'euro');
        if ($eur > 0)  {
        	//echo 
        	$rem = substr($data[3], $eur-6,5) . '|<br>';
        	$firstspace = strpos($rem, ' ');

			$rem = substr($rem, $firstspace);
        	
        	$count += str_replace(',','.',preg_replace('/[^0-9,.]+/', '', $rem));
        	$avgrow++;
        	//echo substr($data[3], $eur-6,5) . '<br>';
        }

        if (strpos($data[3], '€')) {
        	$europost = strrpos($data[3], '€');
        	$numberstart = substr($data[3], $europost+3,9);
        	$numberstart = str_replace(',-', '.00', $numberstart);
            
            //echo $numberstart . "<br />\n";
        	$counteuro += $numberstart;
        	$avgrow++;
        }
        //if ($row == 160) return;
        
    }
    fclose($handle);
}

echo $counteuro + $count . '<br>';
echo 'Average: ' . $count/$avgrow;

//1.981.803.053
?>