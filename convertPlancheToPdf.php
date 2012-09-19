
<?php

$pdf = new FPDF();

$iterator = new DirectoryIterator("planche/");


  foreach ($iterator as $fileinfo) {
        if ($fileinfo->isFile()) {
            echo "Ajout de la planche ".$fileinfo->getFilename()."\r\n";
            $pdf->Image($fileinfo->getPathname(), null, null, 200, 250);
	    $pdf->AddPage();
        }
  }
  
  $pdf->Output("bd.pdf");
  
  ?>