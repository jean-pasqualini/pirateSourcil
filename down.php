<?php
/*

if(!file_exists("page.html"))
{
	file_put_contents("page.html", file_get_contents("http://piratesourcil.blogspot.fr/search?updated-max=2012-09-19T10:50:00%2B02:00&max-results=0"));
}

*/


function png2jpg($originalFile, $outputFile, $quality, $type) {
    
    if($type != 3) return;

    $image = imagecreatefrompng($originalFile);
    imagejpeg($image, $outputFile, $quality);
    imagedestroy($image);
}


set_time_limit(0);

$iterator = new DirectoryIterator("blog-static/");

  foreach ($iterator as $fileinfo) {
        if ($fileinfo->isFile()) {
		echo "Lecture de la page static ".$fileinfo->getFilename()."\r\n";

            	$content = file_get_contents($fileinfo->getPathname());
			
		preg_match_all("#src=\"(?P<url>.+)\.([A-Za-z]{3})\"#i", $content, $matches);

		$nb = count($matches["url"]);
		$i = 1;

		foreach($matches["url"] as $url)
		{
			$url.= ".png";
			
			$filepath = "planche/".md5($url).".jpg";
			
			$contentfile = @file_get_contents($url);
			
			if($contentfile === false)
			{
			      $i++;
			      
			      continue;
			}
			
			if(!file_exists($filepath)) {
			      file_put_contents($filepath, $contentfile);
			}
			else
			{
			      $i++;
			      
			      continue;
			}
			
			if(filesize($filepath) == 0)
			{
			      unlink($filepath);
			      
			      $i++;
			      
			      continue;
			}
		  			
			list($w, $h, $type) = getimagesize($filepath);
			
			if($type != 3 && $type != 2)
			{
			      echo $type;
			      
			      unlink($filepath);
			      
			      $i++;
			      
			      continue;			
			}
			
			png2jpg($filepath, $filepath, 100, $type);
				
			echo "Terminée à ".(($i/$nb) * 100)."%\r\n";
			
			$i++;

		}
        }
    }
    
    

?>
