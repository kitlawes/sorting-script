<?php

// WRITE OUTPUT FILE AS A TRANSFORMATION OF INPUT FILE SO THAT ALL NUMBERS HAVE THE SAME LENGTH USING LEADING ZEROS

$inputFilePath = "../resources/random_100.txt";
$inputFile = fopen($inputFilePath, "r") or die("Unable to open " . $inputFilePath);
$currentDigits = 0;
$maximumDigits = 0;
while (!feof($inputFile)) {
	if (is_numeric(fgetc($inputFile))) {
		$currentDigits++;
		$maximumDigits = max($maximumDigits, $currentDigits);
	} else {
		$currentDigits = 0;
	}
}

$outputFilePath = "../resources/output.txt";
$outputFile = fopen($outputFilePath, "w+") or die("Unable to open " . $outputFilePath);
$number = "";
rewind($inputFile);
while (!feof($inputFile)) {
	$character = fgetc($inputFile);
	if (is_numeric($character)) {
		$number .= $character;
	} else {
		if (ftell($outputFile) > 0) {
			fwrite($outputFile, ",");
		}
		while (strlen($number) < $maximumDigits) {
			$number = "0" . $number;
		}
		fwrite($outputFile, $number);
		$number = "";
	}
}

// REMOVE LEADING ZEROS FROM OUTPUT FILE

$outputFileSize = filesize($outputFilePath);
rewind($outputFile);
$number = "";
$i = 0;
$j = 0;
while ($i <= $outputFileSize) {
	$character = fgetc($outputFile);
	$i++;
	if (is_numeric($character)) {
		if ($character != "0" || $number != "") {
			$number .= $character;
		}
	} else {
		fseek($outputFile, $j);
		if ($j > 0) {
			fwrite($outputFile, ",");
		}
		fwrite($outputFile, $number);
		$number = "";
		$j = ftell($outputFile);
		fseek($outputFile, $i);
	}
}
ftruncate($outputFile, $j);

fclose($inputFile);
fclose($outputFile);

?>