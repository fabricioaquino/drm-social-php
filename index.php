<?php
require_once('vendor/autoload.php');

use setasign\Fpdi\Tcpdf\Fpdi;

// Local dos arquivos
$originalPdf = 'C:\Users\supor\OneDrive\Documentos\projetos\drm-social\files\arquivo.pdf';
$outputPdf = 'C:\Users\supor\OneDrive\Documentos\projetos\drm-social\files\output.pdf';

// Objeto FPDI usando TCPDF
$pdf = new Fpdi();

// PDF original
$pageCount = $pdf->setSourceFile($originalPdf);

// Percorrendo cada página do PDF original
for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
    // Importando uma página do PDF original
    $templateId = $pdf->importPage($pageNo);
    $size = $pdf->getTemplateSize($templateId);

    // Criando uma nova página com o mesmo tamanho do modelo
    $pdf->AddPage($size['orientation'], array($size['width'], $size['height']));

    // Usando a página importada como modelo
    $pdf->useTemplate($templateId);

    // Definindo a fonte e a cor da marca d'água
    $pdf->SetFont('Helvetica', 'B', 50);
    $pdf->SetTextColor(255, 192, 203);
    $pdf->SetAlpha(0.5);

    // Definindo o posicionamento da marca d'água e colocando na página
    $pdf->StartTransform();
    $pdf->Rotate(45, $size['width'] / 2, $size['height'] / 2);
    $pdf->Text($size['width'] / 100, $size['height'] / 2.5, 'Comprado por: 999.999.999-99');
    $pdf->StopTransform();
}
// Colocando senha no arquivo
$pdf->setProtection(['copy', 'print'], '999.999.999-99', null, 0, null, ['mode'=>'128bit']);

// Criando novo PDF
$pdf->Output($outputPdf, 'F');

// Para download direto do arquivo
// $pdf->Output('arquivo.pdf', 'D');

echo "Script finalizado";
