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

fclose($inputFile);
fclose($outputFile);

/*
fseek($inputFile, 1);
$test = fgets($inputFile, 5);
echo $test . "\n";
fseek($inputFile, 5);
$test = fgets($inputFile, 3);
echo $test . "\n";
fseek($inputFile, 2);
$test = fgets($inputFile, 4);
echo $test . "\n";
fwrite($inputFile, "test\n");
fclose($inputFile);
*/

?>