<?php
function encode_items(&$item, $key) {
    if(!is_string($item))
        return;

    $item = htmlentities($item);
    $item = utf8_encode($item);
    $item = nl2br($item);
}

function getStampFromWeek(&$week, &$year)
{
    return strtotime($year . "W" . $week);
}
?>