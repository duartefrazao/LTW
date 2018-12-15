<?php

include_once('../includes/session.php');
include_once('../database/db_upload.php');


function createImageResource($id, $path, $imageTitle){

    if(!fileUploaded())
        return;

    insertNewImage($id, $imageTitle, $path);

    // Generate filenames for original, small and medium files
    $originalFileName = "../images/$path/originals/$id.jpg";
    $mediumFileName = "../images/$path/thumb_medium/$id.jpg";

    // Move the uploaded file to its final destination
    move_uploaded_file($_FILES['image']['tmp_name'], $originalFileName);

    // Crete an image representation of the original image
    $original = imagecreatefromjpeg($originalFileName);
    
    if($path === 'users' || $path === 'channels'){

        $size = getSmallSize($path);

        $smallFileName = "../images/$path/thumb_small/$id.jpg";
        $small = cropImage($original, $size);
        imagejpeg($small, $smallFileName);
    }

    $mediumSize = getMediumSize($path); 

    if($path === 'posts' || $path === 'channels')
        $medium = resize_image($originalFileName, $mediumSize, $mediumSize);
    else
        $medium = cropImage($original, $mediumSize);

    imagejpeg($medium, $mediumFileName);


 }

  function getSmallSize($path){
      switch($path){
        case 'users':
            return 40;
        case 'channels':
            return 40;
        default:
          return 16;
      }
  }

  function getMediumSize($path){
    switch($path){
        case 'users':
            return 70;
        case 'channels':
             return 400;
        case 'posts':
            return 600;
        default:
          return 46;
    }
}

function cropImage($original, $thumbSize){

    $width = imagesx($original);     
    $height = imagesy($original);  
    // calculating the part of the image to use for thumbnail
    if ($width > $height) {
    $y = 0;
    $x = ($width - $height) / 2;
    $smallestSide = $height;
    } else {
    $x = 0;
    $y = ($height - $width) / 2;
    $smallestSide = $width;
    }

    $thumb = imagecreatetruecolor($thumbSize, $thumbSize);
    imagecopyresampled($thumb, $original, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);
    
    return $thumb;
}

function resize_image($file, $w, $h, $crop=FALSE) {
  list($width, $height) = getimagesize($file);
  $r = $width / $height;
  if ($crop) {
      if ($width > $height) {
          $width = ceil($width-($width*abs($r-$w/$h)));
      } else {
          $height = ceil($height-($height*abs($r-$w/$h)));
      }
      $newwidth = $w;
      $newheight = $h;
  } else {
      if ($w/$h > $r) {
          $newwidth = $h*$r;
          $newheight = $h;
      } else {
          $newheight = $w/$r;
          $newwidth = $w;
      }
  }
  $src = imagecreatefromjpeg($file);
  $dst = imagecreatetruecolor($newwidth, $newheight);
  imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

  return $dst;
}

function fileUploaded()
{
    if(empty($_FILES)) {
        return false;       
    } 

    if(!file_exists($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name'])){
        return false;
    }   
    return true;
}

?>