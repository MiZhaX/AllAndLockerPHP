<?php

namespace Lib;

use FPDF;


class PDF extends FPDF
{
    function generarPDF($order): string
    {
        $pdf = new Fpdf();
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, "Detalles del Pedido", 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(50, 10, "ID del Pedido:", 0, 0);
        $pdf->Cell(0, 10, $_SESSION['ultimoId'], 0, 1);
        $pdf->Cell(50, 10, "Usuario:", 0, 0);
        $pdf->Cell(0, 10, $_SESSION['user']['id'], 0, 1);
        $pdf->Cell(50, 10, "Direccion:", 0, 0);
        $pdf->Cell(0, 10, $order['direccion'], 0, 1);
        $pdf->Cell(50, 10, "Fecha:", 0, 0);
        $pdf->Cell(0, 10, $order['fecha'], 0, 1);
        $pdf->Cell(50, 10, "Hora:", 0, 0);
        $pdf->Cell(0, 10, $order['hora'], 0, 1);
        $pdf->Cell(50, 10, "Total:", 0, 0);
        $pdf->Cell(0, 10, "$" . $order['coste'], 0, 1);
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Productos:', 0, 1);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(80, 10, 'Nombre', 1);
        $pdf->Cell(30, 10, 'Cantidad', 1);
        $pdf->Cell(40, 10, 'Precio Unitario', 1);
        $pdf->Cell(30, 10, 'Total', 1);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 12);
        foreach ($_SESSION['cart'] as $product) {
            $pdf->Cell(80, 10, $product['nombre'], 1);
            $pdf->Cell(30, 10, $product['quantity'], 1);
            $pdf->Cell(40, 10, "$" . $product['precio'], 1);
            $pdf->Cell(30, 10, "$" . ($product['precio'] * $product['quantity']), 1);
            $pdf->Ln(10);
        }

        return $pdf->Output('S');
    }
}
