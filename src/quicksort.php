<?php

// Read input file

$inputFilePath = "../resources/random_100.txt";
$inputFile = fopen($inputFilePath, "r") or die("Unable to open " . $inputFilePath);
$inputFileContents = fread($inputFile, filesize($inputFilePath));
fclose($inputFile);

// Sort numbers

$numbers = explode(",", $inputFileContents);
quickSort($numbers, 0, sizeof($numbers) - 1);

function quickSort(&$numbers, $lowerIndex, $higherIndex) {
	if ($lowerIndex < $higherIndex) {
		$partition = partition($numbers, $lowerIndex, $higherIndex);
		quickSort($numbers, $lowerIndex, $partition - 1);
		quickSort($numbers, $partition + 1, $higherIndex);
	}
}

function partition(&$numbers, $lowerIndex, $higherIndex) {
	$pivot = $numbers[$higherIndex];
	$i = $lowerIndex - 1;
	for ($j = $lowerIndex; $j <= $higherIndex - 1; $j++) {
		if ($numbers[$j] <= $pivot) {
			$i++;
			$previousNumber = $numbers[$i];
			$numbers[$i] = $numbers[$j];
			$numbers[$j] = $previousNumber;
		}
	}
	$previousNumber = $numbers[$i + 1];
	$numbers[$i + 1] = $numbers[$higherIndex];
	$numbers[$higherIndex] = $previousNumber;
	return $i + 1;
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