<?php

if($argc!=3){
    die("Usage : php pwi.php in.jpg out.htm".PHP_EOL);
}else{
    $image = $argv[1];
    $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    if($ext != 'jpg' && $ext != 'jpeg'){
        die("Input file must be a jpeg".PHP_EOL);
    }
    $out_file = $argv[2];
}

file_put_contents($out_file, '<style>.pwi{width:1px;height:1px;float:left}</style>');

$size = getimagesize($image);
$imageres = imagecreatefromjpeg($image);

$height = $size[0];
$width = $size[1];

$total = $height * $width - ($height + $width);
$current = 0;

for ($x = 1; $x < $width; $x++) {
    for ($y = 1; $y < $height; $y++) {
        $color = imagecolorat($imageres, $y, $x) . PHP_EOL;
        $color = imagecolorsforindex($imageres, intval($color));
        $out = '<div class="pwi" style="background-color:rgb(' . $color['red'] . ',' . $color['green'] . ',' . $color['blue'] . ')"></div>';
        file_put_contents($out_file, $out, FILE_APPEND);
        echo  "\r"; 
        echo get_progress($current, $total) . "%";
        $current++;
    }
    file_put_contents($out_file, '<div style="clear:both"></div>', FILE_APPEND);
}
echo PHP_EOL;

function get_progress($current, $total) {
    return floor($current * 100 / $total);
}
