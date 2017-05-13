<?php

$inputfilepath = "../resources/random_100.txt";
$inputfile = fopen($inputfilepath, "r") or die("Unable to open " . $inputfilepath);
$inputfilecontents = fread($inputfile, filesize($inputfilepath));
fclose($inputfile);

$numbers = explode(",", $inputfilecontents);
$outputfilecontents = "";
$i = 0;
while ($i < sizeof($numbers)) {
	if ($i == 0 || $numbers[$i - 1] <= $numbers[$i]) {
		$i++;
	} else {
		$previousnumber = $numbers[$i - 1];
		$numbers[$i - 1] = $numbers[$i];
		$numbers[$i] = $previousnumber;
		$i--;
    }
}
for ($i = 0; $i < sizeof($numbers); $i++) {
	if ($i == 0) {
		$outputfilecontents .= $numbers[$i];
    } else {
		$outputfilecontents .= "," . $numbers[$i];
    }
}

$outputfilepath = "../resources/output.txt";
$outputfile = fopen($outputfilepath, "w") or die("Unable to open " . $outputfilepath);
fwrite($outputfile, $outputfilecontents);
fclose($outputfile);

?>