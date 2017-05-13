<?php

// WRITE OUTPUT FILE AS A TRANSFORMATION OF INPUT FILE SO THAT ALL NUMBERS HAVE THE SAME LENGTH USING LEADING ZEROS

$inputFilePath = "../resources/random_100.txt";
$inputFile = fopen($inputFilePath, "r") or die("Unable to open " . $inputFilePath);
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

// SORT NUMBERS

quickSort($outputFile, 0, $numberAmount - 1, $maximumDigits);

function quickSort(&$outputFile, $lowerIndex, $higherIndex, $maximumDigits) {
    if ($lowerIndex < $higherIndex) {
        $partition = partition($outputFile, $lowerIndex, $higherIndex, $maximumDigits);
        quickSort($outputFile, $lowerIndex, $partition - 1, $maximumDigits);
        quickSort($outputFile, $partition + 1, $higherIndex, $maximumDigits);
    }
}

function partition(&$outputFile, $lowerIndex, $higherIndex, $maximumDigits) {
	fseek($outputFile, $higherIndex * ($maximumDigits + 1));
    $pivot = fgets($outputFile, $maximumDigits + 1);
    $i = $lowerIndex - 1;
    for ($j = $lowerIndex; $j <= $higherIndex - 1; $j++) {
		fseek($outputFile, $j * ($maximumDigits + 1));
		$jNumber = fgets($outputFile, $maximumDigits + 1);
        if (intval($jNumber) <= intval($pivot)) {
            $i++;
			fseek($outputFile, $i * ($maximumDigits + 1));
			$iNumber = fgets($outputFile, $maximumDigits + 1);
			fseek($outputFile, $j * ($maximumDigits + 1));
            fwrite($outputFile, $iNumber);
			fseek($outputFile, $i * ($maximumDigits + 1));
            fwrite($outputFile, $jNumber);
        }
    }
	fseek($outputFile, ($i + 1) * ($maximumDigits + 1));
	$iIncrementedNumber = fgets($outputFile, $maximumDigits + 1);
	fseek($outputFile, $higherIndex * ($maximumDigits + 1));
	$higherIndexNumber = fgets($outputFile, $maximumDigits + 1);
	fseek($outputFile, ($i + 1) * ($maximumDigits + 1));
	fwrite($outputFile, $higherIndexNumber);
	fseek($outputFile, $higherIndex * ($maximumDigits + 1));
	fwrite($outputFile, $iIncrementedNumber);
    return $i + 1;
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