
<?php
//200x250

include("fpdf17/fpdf.php");

$pdf = new FPDF();
$pdf->SetFontSize(25);
$pdf->SetTextColor(255);

define("QUALITY", 2.5);
define("LARGEUR_PAGE", 190*QUALITY);
define("HAUTEUR_PAGE", 250*QUALITY);

function getMiniature($file, $ancienneWith, $ancieneHeight, $with, $height)
{
      $img_source = imagecreatefromjpeg($file);
      $img_destination = imagecreatetruecolor($with, $height);
                
      
                
      imagecopyresampled($img_destination, $img_source, 0, 0, 0, 0, $with, $height, $ancienneWith, $ancieneHeight);
      
      $newfile = "tmp/".uniqid()."_miniature.jpg";
                
      imagejpeg($img_destination, $newfile, 100);
      
      return $newfile;
}

function getHeightRatio($w,$h,$NouvelleLargeur)
{
            $Reduction = ( ($NouvelleLargeur * 100)/$w );
             
            // Étape 3 :
            $NouvelleHauteur = ceil(( ($h * $Reduction)/100 ));
            
            return $NouvelleHauteur;
}

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
            $NouvelleHauteur = ceil(( ($h * $Reduction)/100 ));
            
            
            $fileinfo = new SplFileInfo(getMiniature($fileinfo->getPathname(), $w, $h, $NouvelleLargeur, $NouvelleHauteur)); 
            
            $w = $NouvelleLargeur;
            $h = $NouvelleHauteur;
            
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
                $position_x = 0;
                
                if($NouvelleLargeur < LARGEUR_PAGE)
                {
                    $position_x = (LARGEUR_PAGE - $NouvelleLargeur) / 2;
                }
                
                $file = "tmp/".uniqid().".jpg";
                
                $img_source = imagecreatefromjpeg($fileinfo->getPathname());
                $img_destination = imagecreatetruecolor($NouvelleLargeur, $ht);
                
                imagecopyresampled($img_destination, $img_source, 0, 0, 0, $position_y, $NouvelleLargeur, $ht, $w, $ht);
                
                imagejpeg($img_destination, $file, 100);
                
                //$pdf->Image()
                $pdf->Image($file, 10 + $position_x, null, $NouvelleLargeur/QUALITY, $ht/QUALITY);
                //$pdf->AddPage();
            }
            echo "[".$fileinfo->getFilename()."]  ".$w.":".$h." = ".$NouvelleLargeur.":".$NouvelleHauteur."\r\n";
        }
  }
  
  $pdf->Output("bd.pdf");
  
  ?>