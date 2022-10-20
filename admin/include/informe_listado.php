<?php
/*
 * ABC ERP - Sistema ERP para PYMEs
 * Copyright (C) 2014 Santiago Faci <santi@arkabytes.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

require_once("../../include/fpdf/fpdf.php");

/**
 * Crea Informes para listados
 * @author Santiago Faci
 * @version 4 Septiembre 2014
 */
class InformeListado extends FPDF {

    private $titulo;
    private $cabeceras;
    private $columnas;
    private $datos;
    private $anchuras;
    private $filtros;

    /**
     * Inicializa el informe
     * @param $titulo El título del informe que se ubica en la cabecera
     * @param $cabeceras
     * @param $columnas
     * @param $datos
     * @param $anchuras
     */
    function crear($titulo, $cabeceras, $columnas, $datos, $anchuras) {
        $this->titulo = $titulo;
        $this->cabeceras = $cabeceras;
        $this->columnas = $columnas;
        $this->datos = $datos;
        $this->anchuras = $anchuras;

        $this->AliasNbPages();
        $this->AddPage();
        $this->SetCreator("ABC ERP <http://www.acb-erp.com", true);
        $this->SetAuthor("arkabytes");
        $this->SetTitle($titulo, true);

        $this->filtros = array();
    }

    function Header() {
        $this->Image("../img/logo_informes.jpg", 10, 6, 60);
        $this->SetFont("Arial", "B", 7);
        $this->Cell(100);
        $this->Cell($this->w - 130, 10, utf8_decode($this->titulo), 0, 0, "R");
        $this->Ln(20);
    }

    function Footer() {
        $this->SetY(-15);
        $this->Image("../img/logo_abc.jpg", 10, $this->h - 15, 10);
        $this->SetFont("Arial", "B", 5);
        $this->Cell(10);
        $this->Cell(20, 10, "http://www.abc-erp.com", 0, 0);
        $this->Cell(20);
        $this->SetFont("Arial", "B", 7);
        $this->Cell($this->w - 60, 10, utf8_decode("Página ") . $this->PageNo() . "/{nb}", 0, 0, "R");
    }

    /**
     * Escribe el detalle del informe, en forma de tabla
     */
    function escribirDetalle() {
        $this->SetFont("Times", "B", 12);

        $this->SetFillColor(192,192,192);
        $this->SetTextColor(0);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(.3);
        $i = 0;
        $ancho_total = 0;
        foreach ($this->cabeceras as $cabecera) {
            $this->Cell($this->anchuras[$i], 7, utf8_decode($cabecera), 1, 0, "C", true);
            $ancho_total += $this->anchuras[$i];
            $i++;
        }
        $this->Ln();

        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $rellenar = false;
        while ($fila = $this->datos->fetch_array()) {
            for ($i = 0; $i < count($this->columnas); $i++) {
                if ($this->cabeceras[$i] == "Importe")
                    $valor = money_format("%i", $fila[$this->columnas[$i]]);
                else if ($this->cabeceras[$i] == "Fecha")
                    $valor = date("d-m-Y", strtotime($fila[$this->columnas[$i]]));
                else
                    $valor = $fila[$this->columnas[$i]];

                $this->Cell($this->anchuras[$i], 10, utf8_decode($valor), "LR", 0, "L", $rellenar);
            }
            $this->Ln();
            $rellenar = !$rellenar;
        }

        $this->Cell($ancho_total, 0, "", "T");
    }

    /**
     * Crea y muestra el informe en PDF
     */
    function ver() {
        $this->Output();
    }

    function aplicarFiltro($campo, $valor) {

        $this->filtros[$campo] = $valor;
    }

    /**
     * Fuerza la descarga del documento
     */
    function descargar() {
        $this->Output(utf8_decode($this->titulo), "D");
    }
}