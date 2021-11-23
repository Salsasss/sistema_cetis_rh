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
validaPermisoOperacion(6);
if(isset($_SESSION['reporte']) && !empty($_SESSION['reporte'])){
    if(isset($_GET['todos']) && !empty($_GET['todos']) && $_GET['todos']==1){
        $query = 'SELECT * FROM '.$_SESSION['reporte'];
        $docentes = CConecta::consultarSQL($query);
    }else{
        $id_docente = $_GET['id_docente'];
        $docentes[] = CDocente::find($id_docente);
    }

    $campos = array('Nombre','Apellido Paterno','Apellido Materno','Sexo','Edad','Fecha de Nacimiento','Celular','Colonia','Calle','Numero Exterior','Numero Interior','Grado Máximo de estudios','Horas impartidas por Plaza','Fecha de Ingreso a la Institución','Fecha de Registro en el Sistema','Estado');
    $indices = array('nombre','apellido_pat','apellido_mat','sexo','fecha_nac','fecha_nac','celular','colonia','calle','numero_int','numero_ext','grado_estudios','horas_plaza','fecha_ingreso','fecha_registro','estado');

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
    if($docentes){
        foreach($docentes as $docente){
            $pdf->AddPage();
            $pdf->Image('../../multimedia/imagenes/logo_azul.png',10,7,60,25);

            $pdf->SetFont('Arial','',18);
            $pdf->SetXY(80,5);
            $pdf->Cell(120,10,'Reporte General de Docente ',0,0,'R',0);
            $pdf->SetFont('Arial','B',22);
            $pdf->SetXY(80,20);
            $pdf->Cell(120,10,utf8_decode($docente->nombre.' '.$docente->apellido_pat.' '.$docente->apellido_mat),0,0,'R',0);
            $pdf->SetFont('Arial','',12);
            
            $pdf->SetFont('Arial','B',14);
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
            
            $pdf->SetFont('Arial','B',14);
            $pdf->SetXY(10,95);    
            $pdf->Cell(190,10,utf8_decode('Información Personal del Docente'),0,0,'C');
            $pdf->Ln();
            
            $pdf->SetXY(10,110);
            $pdf->SetFont('Arial','',12);

            $i=0;
            //Direccion del Docente
            foreach($campos as $campo){
                $pdf->SetFont('Arial','B',12);
                $pdf->Cell(80,10,utf8_decode($campo.'   '),1,0,'R','true',0);
                $pdf->SetFont('Arial','',12);            
                $pdf->setFillColor(231,232,231);
                if($campo=='Edad'){
                    $pdf->Cell(110,10,'   '.utf8_decode(calculaEdad($docente->fecha_nac).' años'),1,0,'L',0);        
                }else{
                    $indice = $indices[$i];
                    $pdf->Cell(110,10,'   '.utf8_decode($docente->$indice),1,0,'L',0);        
                }
                $pdf->Ln();
                $i++;
            }        
            if($docente->estado=='Inactivo'){       
                $pdf->SetFont('Arial','',12);
                $pdf->setFillColor(255,255,255);
                $pdf->SetX(110);
                if(strlen($docente->motivo_baja)>50){
                    $txt = str_split($docente->motivo_baja,50);
                    for($i=0; $i<count($txt);$i++){
                        $pdf->SetX(93);
                        $pdf->Cell(110,10,utf8_decode($txt[$i]),0,0,'L','true',0);
                        $pdf->Ln();
                        $pdf->SetX(93);
                    }
                    $pdf->Rect(90,210,110,(count($txt)*10));
                }else{
                    $pdf->SetXY(90,210);
                    $pdf->Cell(110,10,utf8_decode('   '.$docente->motivo_baja),1,0,'L','true',0);
                }
                $pdf->SetXY(10,210);
                $pdf->setFillColor(231,232,231);
                $pdf->SetFont('Arial','B',12);
                if(strlen($docente->motivo_baja)>50){
                    $txt = str_split($docente->motivo_baja,50);
                    $pdf->Cell(80,(count($txt)*10),'Motivo de Baja   ',1,0,'R','true',0);
                }else{
                    $pdf->Cell(80,10,'Motivo de Baja   ',1,0,'R','true',0);
                }
            }        
        }
    }

    //Dando nombre al Documento
    if(isset($_GET['todos']) && !empty($_GET['todos']) && $_GET['todos']==1){
        //Reporte General
        $pdf->Output('I','ReporteGeneralDatos.pdf','true');
    }else{
        //Reporte Individual
        $pdf->Output('I',$docente->id_docente.'_'.$docente->apellido_pat.'_'.$docente->apellido_mat.'_ReporteDatos.pdf','true');
    }
}
?>