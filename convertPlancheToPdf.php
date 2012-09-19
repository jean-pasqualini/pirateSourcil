
<?php
//200x250

include("fpdf17/fpdf.php");

$pdf = new FPDF();

define("LARGEUR_PAGE", 190);
define("HAUTEUR_PAGE", 250);

$iterator = new DirectoryIterator("planche/");


  foreach ($iterator as $fileinfo) {
        if ($fileinfo->isFile()) {
            echo "Ajout de la planche ".$fileinfo->getFilename()."\r\n";
            
            list($w, $h) = getimagesize($fileinfo->getPathname());
            
            if($w > LARGEUR_PAGE) {
                $NouvelleLargeur = LARGEUR_PAGE;
            }
            else
            {
                $NouvelleLargeur = $w;
            }
            
            // Étape 1 :
            
             
            // Étape 2 :
            $Reduction = ( ($NouvelleLargeur * 100)/$w );
             
            // Étape 3 :
            $NouvelleHauteur = ( ($h * $Reduction)/100 );
            
            $nombrePage = ceil($NouvelleHauteur/HAUTEUR_PAGE);
            
            for($p = 1; $p<= $nombrePage; $p++)
            {
                if($p == $nombrePage)
                {
                    $ht = $NouvelleHauteur - (HAUTEUR_PAGE * ($nombrePage -1) );
                }
                else
                {
                    $ht = HAUTEUR_PAGE;
                }
                
                $position_y = HAUTEUR_PAGE * ( $p - 1);
                
                $file = "tmp/".uniqid().".jpg";
                
                $img_source = imagecreatefromjpeg($fileinfo->getPathname());
                $img_destination = imagecreatetruecolor(LARGEUR_PAGE, $ht);
                
                imagecopyresampled($img_destination, $img_source, 0, 0, 0, $position_y, $NouvelleLargeur, $ht, $w, $ht);
                
                imagejpeg($img_destination, $file, 100);
                
                $pdf->Image($file, 10, null, $NouvelleLargeur, $ht);
                //$pdf->AddPage();
            }
        }
  }
  
  $pdf->Output("bd.pdf");
  
  ?>