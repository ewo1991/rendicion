<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    // Incluimos el archivo fpdf
    require_once APPPATH."third_party/fpdf/fpdf.php";
 
    //Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones
    class Pdf extends FPDF {
        public function __construct() {
            parent::__construct();
        }
        // El encabezado del PDF
        public function Header(){
            $this->Image(APPPATH.'/third_party/fpdf/imagenes/unsm.png',10,8,22);
            $this->SetFont('Times','BU',16);
            $this->Cell(30);
            $this->Cell(120,10,'UNIVERSIDAD NACIONAL DE SAN MARTIN',0,0,'C');
//            $this->Ln('5');$this->Cell(30);
//            $this->SetFont('Arial','B',8);
//            $this->Cell(30);
//            $this->Cell(120,10,'INGENIERIA DE SISTEMAS E INFORMATICA',0,0,'C');
//            $this->Image(APPPATH.'/third_party/fpdf/imagenes/fisi.png',175,8,22);
//            $this->Ln(20);
            $this->Ln(8);
       }
       // El pie del pdf
       public function Footer(){
           $this->SetY(-15);
           $this->SetFont('Times','I',14);
           $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
      }
    }
?>