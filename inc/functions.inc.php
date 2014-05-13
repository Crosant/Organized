<?php 
function encode_items(&$item, $key)
{
    $item = utf8_encode($item);
    $item = htmlentities($item);
}
?>