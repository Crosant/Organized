<?php
function encode_items(&$item, $key) {
	$item = utf8_encode($item);
	$item = htmlentities($item);
}

function getStampFromWeek($week, $year) {
	$startStamp = mktime(0, 0, 0, 1, $week * 7, $year);
	$isoWeek = date('W', $startStamp);
	if ($isoWeek != $week) {
		$startStamp = mktime(0, 0, 0, 1, --$week * 7, $year);
	}
	$dow = date('w', $startStamp);
	if (--$dow == -1) {
		$dow = 6;
	}
	return ($startStamp - $dow * 86400);
}
?>