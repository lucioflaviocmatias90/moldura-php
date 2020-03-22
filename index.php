<?php

/**
 * Criar uma nova imagem com a foto da criança sobreescrevendo com a moldura selecionada
 *
 * @param resource $dst_im
 * @param resource $src_im
 * @param int $dst_x
 * @param int $dst_y
 * @param int $src_x
 * @param int $src_y
 * @param int $src_w
 * @param int $src_h
 * @param int $pct
 * @return void
 */
function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){ 
    // creating a cut resource 
    $cut = imagecreatetruecolor($src_w, $src_h); 

    // copying relevant section from background to the cut resource 
    imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h); 

    // copying relevant section from watermark to the cut resource 
    imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h); 

    // insert cut resource to destination image 
    imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);

    $text = utf8_decode("Minha festinha: 23/04/2020 às 14h30hs");

    $textColor = imagecolorallocate($dst_im, 255, 0, 255);

    $font = './public/font/Minnie.TTF';

    imagettftext($dst_im, 43, 0, 50, $src_h-100, $textColor, $font, $text);
    
    imagepng($dst_im, './'.(new DateTime())->format('Y-m-d_H:i:s').'_convite.png');

    imagedestroy($cut);
}

$photo = imagecreatefromjpeg('./public/foto.jpg');
$frame = imagecreatefrompng('./public/moldura.png');

imagecopymerge_alpha($photo, $frame, 0, 0, 0, 0, imagesx($frame), imagesy($frame), 100);

imagedestroy($frame);
imagedestroy($photo);

echo "deu certo";
