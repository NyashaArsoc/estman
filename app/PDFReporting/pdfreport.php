<?php

namespace App\PDFReporting;

use TCPDF;

class pdfreport extends TCPDF {
    protected $headerTitle;
    // Page header
    public function Header() {
        $timestamp = strtotime(now());
        // Logo
        $imageFile = base_path('public/img/ESTMAN-ICON.png'); // Update with your logo path
       $this->Image($imageFile, 12, 5, 20, 10, 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);

        // Title\
        $this->SetY(5);
        $this->SetFont('helvetica', 'B', 13);
        $this->Cell(65, 3, $this->headerTitle, 0, true, 'C');
        $this->SetFont('helvetica', 'I', 6);
        
        $this->Cell(41, 3, date('M j, y', $timestamp), 0, true, 'C'); // Header string
        // Draw a line below the header
    $this->Line(10, 15, 200, 15); // x1, y1, x2, y2 (adjust as needed)
        // Line break
        $this->Ln(10);
    }

    // Page footer
    public function Footer() {
        $this->SetY(-10);
        // Draw a line above the footer
    $this->Line(10, $this->GetY(), 200, $this->GetY()); // x1, y1, x2, y2
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C');
    }
    public function setHeaderTitle($title) {
        $this->headerTitle = $title;
    }
}