<?php

// Read input file

$inputFilePath = "../resources/random_100.txt";
$inputFile = fopen($inputFilePath, "r") or die("Unable to open " . $inputFilePath);
$inputFileContents = fread($inputFile, filesize($inputFilePath));
fclose($inputFile);

// Sort numbers

$numbers = explode(",", $inputFileContents);
$i = 0;
while ($i < sizeof($numbers)) {
	if ($i == 0 || $numbers[$i - 1] <= $numbers[$i]) {
		$i++;
	} else {
		$previousNumber = $numbers[$i - 1];
		$numbers[$i - 1] = $numbers[$i];
		$numbers[$i] = $previousNumber;
		$i--;
    }
}

// Write output file

$outputFileContents = "";
for ($i = 0; $i < sizeof($numbers); $i++) {
	if ($i == 0) {
		$outputFileContents .= $numbers[$i];
    } else {
		$outputFileContents .= "," . $numbers[$i];
    }
}

$outputFilePath = "../resources/output.txt";
$outputFile = fopen($outputFilePath, "w") or die("Unable to open " . $outputFilePath);
fwrite($outputFile, $outputFileContents);
fclose($outputFile);

?>