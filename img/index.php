<?php

//http://api.neofyt.com/img/?300.150.558ed5.ffffff

function parse_query($query) {

    $array = explode('.', $query);

    // Nouvelle image
	$im = imagecreate($array[0], $array[1]);

	// Définitions des couleurs
	$bg = imagecolorallocate($im, 
							base_convert(substr($array[2], 0, 2), 16, 10), 
							base_convert(substr($array[2], 2, 2), 16, 10),
							base_convert(substr($array[2], 2, 4), 16, 10));
	$textcolor = imagecolorallocate($im, 
								base_convert(substr($array[3], 0, 2), 16, 10), 
								base_convert(substr($array[3], 2, 2), 16, 10),
								base_convert(substr($array[3], 2, 4), 16, 10));

	$text = (empty($array[4])) ? $array[0]."x".$array[1] : urldecode($array[4]);

	// Ajout des dimensions
	imagestring($im, 
				5, // Taille de la police
				($array[0]/2)-(imagefontwidth(5)*strlen($text))/2, // Centrage horizontal
				($array[1]/2)-(imagefontheight(5)/2), // Centrage vertical
				$text, 
				$textcolor);

	// Affichage de l'image
	header('Content-type: image/png');

	imagepng($im);
	imagedestroy($im);
}

$query = $_SERVER['QUERY_STRING'];

if ($query !== ""){
    parse_query($query);
} else {
    echo '{"error": "query missing"}';
}
	
?>