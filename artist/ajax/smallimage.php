<?php

function smallimage($orig_file, $new_fname, $resize_width){

	// GDライブラリがインストールされているか
	if (!extension_loaded('gd')) {
	    // エラー処理
	    return false;	
	}

	// 画像情報取得
	$result = getimagesize($orig_file);
	list($orig_width, $orig_height, $image_type) = $result;
	
	// 画像をコピー
	$im =NULL;
	switch ($image_type) {
	    // 1 IMAGETYPE_GIF
	    // 2 IMAGETYPE_JPEG
	    // 3 IMAGETYPE_PNG
            case 1: $im = imagecreatefromgif($orig_file); break;
            case 2: $im = imagecreatefromjpeg($orig_file);  break;
            case 3: $im = imagecreatefrompng($orig_file); break;
            default: break;
        }
	if(empty($im)){
		return(false);
	}

	$resize_height = round($orig_height * $resize_width / $orig_width);
	
	// コピー先となる空の画像作成
	$new_image = imagecreatetruecolor($resize_width, $resize_height);
	if (!$new_image)
	{
		// エラー処理 
	// 不要な画像リソースを保持するメモリを解放する
		imagedestroy($im);
		return(false);
		
	}	

	if($image_type==1 || $image_type==3){
		imagealphablending($new_image, false);
		imagesavealpha($new_image, true);
		$transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
		imagefilledrectangle($new_image, 0, 0, $resize_width, $resize_height, $transparent);	
	}

	$ret=imagecopyresampled($new_image, $im, 0, 0, 0, 0, $resize_width, $resize_height, $orig_width, $orig_height);
	if(!$ret){
		imagedestroy($im);
		imagedestroy($new_image);
		return(false);		
	}

	switch ($image_type) {
	// 1 IMAGETYPE_GIF
	// 2 IMAGETYPE_JPEG
	// 3 IMAGETYPE_PNG
		case 1: $result = imagegif($new_image, $new_fname, 75); break;
		case 2: $result = imagejpeg($new_image, $new_fname); break;
		case 3: $result = imagepng($new_image, $new_fname, 5); break;
		default: //エラー処理 
		return(false);
	}

	if (!$result) {
		// エラー処理 
	// 不要な画像リソースを保持するメモリを解放する
		imagedestroy($im);
		imagedestroy($new_image);
		return(false);
	}

	// 不要になった画像データ削除
	imagedestroy($im);
	imagedestroy($new_image);		
	
}

?>