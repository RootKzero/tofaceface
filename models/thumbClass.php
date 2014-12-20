<?php 

class thumbnail 
    { 
        private $image; 
        private $size_x; 
        private $size_y; 
		
        function thumbnail( $url ) 
        {
        	 $this->image=$url;
		} 
        function size( $size_x, $size_y ) 
        {
        	 $this->size_x = $size_x;
        	 $this->size_y = $size_y;
		} 
        function show() 
        {
        	if ( file_exists( $this->image ) )
		  {
			
            header("Content-type: image/jpeg"); 
                
                $imageinfo = getimagesize ( $this->image ); 
	            $x = $imageinfo[0]; 
	            $y = $imageinfo[1]; 
	            if ( $imageinfo[2] == 1 )    $original_image=imagecreatefromgif($this->image); 
	            if ( $imageinfo[2] == 2 )    $original_image=imagecreatefromjpeg($this->image); 
	            if ( $imageinfo[2] == 3 )    $original_image=imagecreatefrompng($this->image); 
	            if ( $imageinfo[2] > 3 )        die('Formato de imagen no soportado'); 

	            $resize_x = $this->size_x / $x; 
	            $resize_y = $this->size_y / $y; 
	            if ( $resize_x < $resize_y ) 
	            $resize = $resize_x; 
	            else $resize = $resize_y; 
	
	            $im    = imagecreatetruecolor( ceil ( $x * $resize ), ceil( $y * $resize ) );
				imagefill( $im, 0, 0, imagecolorallocate( $im, 255, 255, 255 ) );
				imagealphablending( $im, TRUE );
	            imagecopyresampled( $im, $original_image,0,0,0,0, ceil( $x * $resize ), ceil( $y * $resize ), $x, $y ); 
	            
	            imagejpeg( $im, $name, 90 ); 
	            imagedestroy( $im ); 
	         }//====== IF
	         
	         else 
			{
				header ('HTTP/1.1 404 Not Found');
				die('Error 404'); // ERROR 404
			}
        } 
    } 
?>