<?php

// Write the numbers from $inputFile into $outputFile
// Add leading zeros to the numbers so that they all have the same amount of digits
function addLeadingZeros(&$inputFile, &$outputFile, $maximumDigits) {

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

}

// Remove leading zeros from the numbers in $outputFile
function removeLeadingZeros(&$outputFile) {

	$outputFileSize = filesize(stream_get_meta_data($outputFile)["uri"]);
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

}

?>