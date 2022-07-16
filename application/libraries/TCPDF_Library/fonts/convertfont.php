<?php
include('../tcpdf.php');

$pdf = new TCPDF_FONTS('P', 'mm', 'A5', true, 'UTF-8', false);

$pdf->addTTFFont('./B Nazanin.ttf', 'TrueTypeUnicode');
