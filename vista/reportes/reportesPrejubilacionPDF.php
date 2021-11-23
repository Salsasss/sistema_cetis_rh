<?php
include('../../control/funciones/ctrlFunciones.php');
require('../../modelo/fpdf182/fpdf.php');
include('../../control/database/database.php');
require('../../modelo/CDocente.php');
require('../../modelo/CConecta.php');
require('../../modelo/CUsuario.php');
$db = conectarDB();
CConecta::setDB($db);

session_start();
mb_http_output('UTF-8');
verificarSesion();
validaPermisoOperacion(8);
if(isset($_GET['todos']) && !empty($_GET['todos']) && $_GET['todos']==1){
    $query = "SELECT * FROM docentes WHERE estado='Prejubilatorio'";
    $docentes = CConecta::consultarSQL($query);
}else{
    $id_docente = $_GET['id_docente'];
    $docentes[] = CDocente::find($id_docente);
}

$campos = array('Nombre Completo','Sexo','Edad','Fecha de Nacimiento','Años de Servicio','Fecha de Ingreso a la Institución');
$indices = array('nombre','sexo','fecha_nac','fecha_nac','','fecha_registro');


class PDF extends FPDF{
    function footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','I',12);
        $this->setFillColor(231,232,231);
        $this->Cell(0,10,'Pagina '.$this->PageNo(),0,0,'C','true');
    }
}

$pdf = new PDF();
$pdf->SetFont('Arial','',12);
$pdf->SetTextColor(0,0,0);

foreach($docentes as $docente){    
    if(!empty($docente)){//con esta condicion ignoramos la posicion vacia del arreglo
        $pdf->AddPage();
        $pdf->SetFont('Arial','',12);
        $pdf->SetTextColor(0,0,0);

        $pdf->Image('../../multimedia/imagenes/logo_azul.png',10,7,60,25);

        $pdf->SetFont('Arial','',18);
        $pdf->SetXY(80,5);
        $pdf->Cell(120,10,'Reporte de Procesos Prejubilatorios',0,0,'R',0);
        $pdf->SetFont('Arial','B',22);
        $pdf->SetXY(80,20);
        $pdf->Cell(120,10,utf8_decode($docente->nombre),0,0,'R',0);
        $pdf->SetFont('Arial','',12);
        
        $pdf->SetFont('Arial','B',12);
        $pdf->SetXY(10,35);
        $pdf->Cell(190,10,utf8_decode('Claves Únicas del Docente'),0,0,'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('Arial','',12);
        //columna1
        $pdf->SetXY(10,50);
        $pdf->SetFont('Arial','B',12);
        $pdf->setFillColor(231,232,231);
        $pdf->Cell(90,10,'Clave del Docente',1,0,'C','true',0);
        $pdf->Ln();

        $pdf->SetFont('Arial','',12);
        $pdf->Cell(90,10,$docente->id_docente,1,0,'C',0);
        
        //columna2
        $pdf->SetFont('Arial','B',12);
        $pdf->setFillColor(231,232,231);
        $pdf->SetXY(110,50);
        $pdf->Cell(90,10,'CURP',1,0,'C','true',0);

        $pdf->SetXY(110,60);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(90,10,$docente->curp,1,0,'C',0);

        //columna1
        $pdf->SetFont('Arial','B',12);
        $pdf->SetXY(10,70);
        $pdf->setFillColor(231,232,231);
        $pdf->Cell(90,10,'NSS',1,0,'C','true',0);
        $pdf->Ln();

        $pdf ->SetFont('Arial','',12);
        $pdf->Cell(90,10,$docente->nss,1,0,'C',0);

        //columna2
        $pdf->SetFont('Arial','B',12);
        $pdf->setFillColor(231,232,231);
        $pdf->SetXY(110,70);
        $pdf->Cell(90,10,'RFC',1,0,'C','true',0);

        $pdf->SetXY(110,80);    
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(90,10,$docente->rfc,1,0,'C',0);
        

        $pdf->SetFont('Arial','B',12);
        $pdf->SetXY(10,95);    
        $pdf->Cell(190,10,utf8_decode('Información del proceso Prejubilatorio'),0,0,'C');
        $pdf->Ln();

        $pdf->SetXY(10,110);
        
        $i=0;
        foreach($campos as $campo){
            $pdf->SetFont('Arial','B',12);
            $pdf->setFillColor(231,232,231);
            $pdf->Cell(80,10,utf8_decode($campo.'   '),1,0,'R','true',0);

            $pdf->SetFont('Arial','',12);
            $pdf->setFillColor(255,255,255);
            if($campo=='Edad'){
                $pdf->Cell(110,10,utf8_decode('   '.calculaEdad($docente->fecha_nac).' años'),1,0,'L','true',0);
            }else if($campo=='Años de Servicio'){
                $pdf->Cell(110,10,utf8_decode('   '.calculaEdad($docente->fecha_registro).' años'),1,0,'L','true',0);
            }else{
                $indice = $indices[$i];
                $pdf->Cell(110,10,utf8_decode('   '.$docente->$indice),1,0,'L','true',0);        
            }
            $pdf->SetTextColor(0,0,0);
            $pdf->Ln();
            $i++;
        }
        $pdf->SetTextColor(0,0,0);
    }
}                                           
//Dando nombre al Documento
if(isset($_GET['todos']) && !empty($_GET['todos']) && $_GET['todos']==1){
    //Reporte General
    $pdf->Output('I','ReporteGeneralPrejubilaciones.pdf','true');
}else{
    //Reporte Individual
    $pdf->Output('I',$docente->id_docente.'_'.$docente->apellido_pat.'_'.$docente->apellido_mat.'_ReportePrejubilacion.pdf','true');    
}


?>