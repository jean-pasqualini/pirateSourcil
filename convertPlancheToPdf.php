
<?php
//200x250

include("fpdf17/fpdf.php");

$pdf = new FPDF();

$iterator = new DirectoryIterator("planche/");


  foreach ($iterator as $fileinfo) {
        if ($fileinfo->isFile()) {
            echo "Ajout de la planche ".$fileinfo->getFilename()."\r\n";
            
            list($w, $h) = getimagesize($fileinfo->getPathname());
            
            // Étape 1 :
            $NouvelleLargeur = 190;
             
            // Étape 2 :
            $Reduction = ( ($NouvelleLargeur * 100)/$w );
             
            // Étape 3 :
            $NouvelleHauteur = ( ($h * $Reduction)/100 );
            
            $pdf->Image($fileinfo->getPathname(), null, null, $NouvelleLargeur, $NouvelleHauteur);
	    $pdf->AddPage();
        }
  }
  
  $pdf->Output("bd.pdf");
  
  ?>