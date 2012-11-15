<?php

header('Content-Type: application/json; charset=utf-8');

function parse_query($query) {
    $return = "{";

    $pairs = explode('&', $query);

    foreach($pairs as $pair) {
        list($name, $value) = explode('=', $pair, 2);
        if (preg_match('/^callback/', $name)  or preg_match('/^\_/', $name)){
            
        } else if (preg_match('/^\d+\.*\d+$/', $value) ){
            $return = $return.'"'.$name.'":'.$value.',';
        } else {
            $return = $return.'"'.$name.'":'.'"'.$value.'",';
        }
    }

    $return = trim($return, ",");
    $return = $return."}";
    return urldecode($return);
}

$query = $_SERVER['QUERY_STRING'];

if ($query !== ""){
    $json = parse_query($query);
} else {
    echo '{"error": "query missing"}';
}

if (isSet($_GET['callback'])) {
    echo $_GET['callback'].'('.$json.');';
} else {
    echo $json;
}

?>