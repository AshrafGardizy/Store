<?php
require_once(dirname(__FILE__) . '/TCPDF_Library/tcpdf.php');
/**
* PDF
*/
class Pdf extends TCPDF
{
    public function Header() {
        // Logo
        // $image_file = K_PATH_IMAGES.'logo_example.jpg';
        // $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('btitrb', 'B', 18);
        // Title
        $this->Cell(0, 15, 'فرهیخته گروپ', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('courier', 'B', 20);
        // Page number
        $this->Cell(0, 20, 'Ashraf-Gardizy', 0, false, 'L', 0, '', 0, false, 'T', 'M');
    }
}
