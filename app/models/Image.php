<?php
/** Image manipulation class */
namespace Model;

defined('ROOTPATH') OR exit('Access Denied');
class Image
{

    public function resize($filename, $max_size = 700)
    {
        /** check what kind of file type it is  */
        $type = mime_content_type($filename);

        if(file_exists($filename)){
            switch($type){
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($filename);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($filename);
                    break;
                case 'image/gif':
                    $image = imagecreatefromgif($filename);
                    break;
                case 'image/webp':
                    $image = imagecreatefromwebp($filename);
                    break;
                default:
                    return $filename;
                    break;
            }
            $src_width = imagesx($image);
            $src_height = imagesy($image);

            if($src_width > $src_height){
                //reduce max size if image is smaller
                if($src_width < $max_size){
                    $max_size = $src_width;
                }
                $dst_width = $max_size;
                $dst_height = ($src_height/$src_width)*$max_size;
            }else{

                //reduce max size if image is smaller
                if($src_height < $max_size){
                    $max_size = $src_height;
                }

                $dst_width = ($src_width/$src_height)*$max_size;
                $dst_height = $max_size;
            }
            $dst_width = round($dst_width);
            $dst_height = round($dst_height);

            $dst_image = imagecreatetruecolor($dst_width,$dst_height);
            if($type == 'image/png'){
                imagealphablending($dst_image, false);
                imagesavealpha($dst_image, true);
            }
            imagecopyresampled($dst_image, $image, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

            imagedestroy($image);

            switch($type){
                case 'image/jpeg':
                    imagejpeg($dst_image, $filename,90);
                    break;
                case 'image/png':
                    imagepng($dst_image, $filename,8);
                    break;
                case 'image/gif':
                    imagegif($dst_image, $filename);
                    break;
                case 'image/webp':
                    imagewebp($dst_image, $filename,90);
                    break;
                default:
                    imagejpeg($dst_image, $filename,90);
                    break;

            }
            imagedestroy($dst_image);
        }
        return $filename;
    }
}