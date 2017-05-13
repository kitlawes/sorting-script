<?php

// Sort the numbers in $outputFile in-place in ascending order
function quickSortInPlace(&$outputFile, $lowerIndex, $higherIndex, $maximumDigits) {
    if ($lowerIndex < $higherIndex) {
        $partition = partition($outputFile, $lowerIndex, $higherIndex, $maximumDigits);
        quickSortInPlace($outputFile, $lowerIndex, $partition - 1, $maximumDigits);
        quickSortInPlace($outputFile, $partition + 1, $higherIndex, $maximumDigits);
    }
}

// Partition numbers in $outputFile either side of a pivot number with index $higherIndex
// Numbers smaller than the pivot number are moved to the left of the pivot number
// Numbers larger than the pivot number are moved to the right of the pivot number
function partition(&$outputFile, $lowerIndex, $higherIndex, $maximumDigits) {

	fseek($outputFile, $higherIndex * ($maximumDigits + 1));
    $pivot = fgets($outputFile, $maximumDigits + 1);
    $i = $lowerIndex - 1;
    for ($j = $lowerIndex; $j <= $higherIndex - 1; $j++) {
		fseek($outputFile, $j * ($maximumDigits + 1));
		$jNumber = fgets($outputFile, $maximumDigits + 1);
        if (intval($jNumber) <= intval($pivot)) {
            $i++;
			swapNumbers($outputFile, $i, $j, $maximumDigits);
        }
    }
    swapNumbers($outputFile, $i + 1, $higherIndex, $maximumDigits);
    return $i + 1;
    
}

// Swap numbers in $outputFile with indexes $i and $j
// This function assumes that all numbers in $outputFile have $maximumDigits digits with leading zeros
function swapNumbers(&$outputFile, $i, $j, $maximumDigits) {
	fseek($outputFile, $i * ($maximumDigits + 1));
	$iNumber = fgets($outputFile, $maximumDigits + 1);
	fseek($outputFile, $j * ($maximumDigits + 1));
	$jNumber = fgets($outputFile, $maximumDigits + 1);
	fseek($outputFile, $i * ($maximumDigits + 1));
	fwrite($outputFile, $jNumber);
	fseek($outputFile, $j * ($maximumDigits + 1));
	fwrite($outputFile, $iNumber);
}

?>