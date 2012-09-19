<?php
/*

if(!file_exists("page.html"))
{
	file_put_contents("page.html", file_get_contents("http://piratesourcil.blogspot.fr/search?updated-max=2012-09-19T10:50:00%2B02:00&max-results=0"));
}

*/


set_time_limit(0);

$iterator = new DirectoryIterator("blog-static/");

  foreach ($iterator as $fileinfo) {
        if ($fileinfo->isFile()) {
		echo "Lecture de la page static ".$fileinfo->getFilename()."\r\n";

            	$content = file_get_contents($fileinfo->getPathname());
			
		preg_match_all("#src=\"(?P<url>.+).png\"#i", $content, $matches);

		$nb = count($matches["url"]);
		$i = 1;

		foreach($matches["url"] as $url)
		{
			$url.= ".png";
			
			if(!file_exists("planche/".md5($url).".png")) file_put_contents("planche/".md5($url).".png", file_get_contents($url));

			echo "Terminée à ".(($i/$nb) * 100)."%\r\n";

			$i++;
		}
        }
    }

?>
