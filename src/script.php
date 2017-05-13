<?php

include 'transforming_with_leading_zeros.php';
include 'sorting_in_place.php';

// Open resources
$inputFilePath = "../resources/random_100.txt";
$inputFile = fopen($inputFilePath, "r") or die("Unable to open " . $inputFilePath);
$outputFilePath = "../resources/output.txt";
$outputFile = fopen($outputFilePath, "w+") or die("Unable to open " . $outputFilePath);

// Find the maximum number of digits and the amount of numbers
$currentDigits = 0;
$maximumDigits = 0;
$numberAmount = 0;
while (!feof($inputFile)) {
	if (is_numeric(fgetc($inputFile))) {
		$currentDigits++;
		$maximumDigits = max($maximumDigits, $currentDigits);
	} else {
		$currentDigits = 0;
		$numberAmount++;
	}
}

// In-place sorting
addLeadingZeros($inputFile, $outputFile, $maximumDigits);
quickSortInPlace($outputFile, 0, $numberAmount - 1, $maximumDigits);
removeLeadingZeros($outputFile);

// Close resources
fclose($inputFile);
fclose($outputFile);

?>