<?php

$inputfilepath = "../resources/random_100.txt";
$inputfile = fopen($inputfilepath, "r") or die("Unable to open " . $inputfilepath);
$contents = fread($inputfile, filesize($inputfilepath));
fclose($inputfile);

$outputfilepath = "../resources/output.txt";
$outputfile = fopen($outputfilepath, "w") or die("Unable to open " . $inputfilepath);
fwrite($outputfile, $contents);
fclose($outputfile);

?>