<?php

//http://api.neofyt.com/jquery/?1.7.1
//http://api.neofyt.com/jquery/?1.7.1-min
//http://api.neofyt.com/jquery/?latest

header('Content-type: text/javascript');

function parse_query($query) {

    $array = explode('-', $query);

    if ($array[1]){
        $min = ".min";
    }

    if (is_file("files/jquery-".$array[0].$min.".js")){
        $jquery = file_get_contents("files/jquery-".$array[0].$min.".js");
    } else {
        echo "console.warn('Error loading the jquery file. Wrong version number...')"; 
    }
   
    echo $jquery; 
}

function getLast(){
    $arr = glob('files/jquery-*.js');
    sort($arr);
    $jquery = file_get_contents(array_pop($arr));
    echo $jquery;
}


$query = $_SERVER['QUERY_STRING'];

if($query === "last"){
    getLast($query);
} else if ($query !== ""){
    parse_query($query);
} else {
    echo "console.warn('Error loading the jquery file. Version number in the API call is empty...')"; 
}
    
?>