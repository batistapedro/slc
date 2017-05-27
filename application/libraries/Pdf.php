<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    // Incluimos el archivo fpdf
require_once APPPATH."/third_party/fpdf/fpdf.php";

//Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones
class Pdf extends FPDF
{
    public function __construct()
    {
        parent::__construct();
      }
        // El encabezado del PDF
   // public function Header($ancho)
    //{
        //ancho pagina normal =200
       // $this->Cell(200,9,$this->Image('http://localhost/slc/public/img/banner.jpg',7,7,200),0,1,'C');
        //$this->Ln();
       
    //}
       // El pie del pdf

  // public function Footer()
   //{
      // $this->SetY(-10);
       //$this->SetFont('Arial','',8);
       //$this->Cell(180,10,'Pagina '.$this->PageNo(),0,1,'R');
   //}

}
?>
