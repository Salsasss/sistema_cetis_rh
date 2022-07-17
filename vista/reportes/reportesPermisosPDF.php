<?php
include('../../control/funciones/ctrlFunciones.php');
require('../../modelo/fpdf182/fpdf.php');
include('../../control/database/database.php');
require('../../modelo/CDocente.php');
require('../../modelo/CConecta.php');
require('../../modelo/CPermiso.php');
require('../../modelo/CUsuario.php');
$db = conectarDB();
CConecta::setDB($db);

session_start();
mb_http_output('UTF-8');
verificarSesion();
validaPermisoOperacion(11);
if(isset($_SESSION['reporte']) && !empty($_SESSION['reporte'])){
    if(isset($_GET['todos']) && !empty($_GET['todos']) && $_GET['todos']==1){
        $query = $_SESSION['reporte'];
        $docentes = CConecta::consultarSQL($query);
    }else{
        $id_docente = $_GET['id_docente'];
        $docentes[] = CDocente::find($id_docente);
    }

    class PDF extends FPDF{
        function footer(){
            $this->SetY(-15);
            $this->SetFont('Arial','I',12);
            $this->setFillColor(231,232,231);
            $this->Cell(0,10,'Pagina '.$this->PageNo(),0,0,'C','true');
        }
    }
    $pdf = new PDF();
    if($docentes){
        foreach($docentes as $docente){
            $campos = array('Nombre','Apellido Paterno','Apellido Materno','Permisos Disponibles');
            $indices = array('nombre','apellido_pat','apellido_mat');

            $mesesMasUsados = array();
            
            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");            
            $pdf->AddPage();
            $pdf->SetFont('Arial','',12);
            $pdf->SetTextColor(0,0,0);

            $pdf->Image('../../multimedia/imagenes/logo_azul.png',10,7,60,25);

            $pdf->SetFont('Arial','',18);
            $pdf->SetXY(80,5);
            $pdf->Cell(120,10,utf8_decode('Reporte de Permisos Económicos'),0,0,'R',0);
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
            $pdf->SetXY(10,74);
            $pdf->setFillColor(231,232,231);
            $pdf->Cell(90,10,'NSS',1,0,'C','true',0);
            $pdf->Ln();

            $pdf ->SetFont('Arial','',12);
            $pdf->Cell(90,10,$docente->nss,1,0,'C',0);

            //columna2
            $pdf->SetFont('Arial','B',12);
            $pdf->setFillColor(231,232,231);
            $pdf->SetXY(110,74);
            $pdf->Cell(90,10,'RFC',1,0,'C','true',0);

            $pdf->SetXY(110,84);    
            $pdf->SetFont('Arial','',12);
            $pdf->Cell(90,10,$docente->rfc,1,0,'C',0);
            

            $pdf->SetFont('Arial','B',14);
            $pdf->SetXY(10,97);
            $pdf->Cell(190,10,utf8_decode('Información de los Permisos Económicos'),0,0,'C');
            $pdf->Ln();

            $pdf->SetXY(10,110);
            $i=0;
            foreach($campos as $campo){                
                $pdf->SetFont('Arial','B',12);
                $pdf->setFillColor(231,232,231);
                $pdf->Cell(80,10,utf8_decode($campo.'   '),1,0,'R','true',0);

                $pdf->SetFont('Arial','',12);
                $pdf->setFillColor(255,255,255);
                if($campo=='Permisos Disponibles'){
                    $pdf->Cell(110,10,utf8_decode('   '.CPermiso::permisosDisponibles($docente->id_docente)),1,0,'L','true',0);
                }else{
                    $indice = $indices[$i];
                    $pdf->Cell(110,10,utf8_decode('   '.$docente->$indice),1,0,'L','true',0);
                }

                $pdf->SetTextColor(0,0,0);
                $pdf->Ln();
                $i++;
            }
            $permisos = CPermiso::find($docente->id_docente);
            $i = 0;

            $pdf->SetXY(10,152.5);
            $pdf->SetFont('Arial','B',14);
            $pdf->Cell(190,10,utf8_decode('Permisos Utilizados'),0,0,'C');

            $pdf->SetXY(10,165);
            if(count($permisos) == 0){
                //Si no hay permisos
                $pdf->SetFont('Arial','B',12);
                $pdf->setFillColor(231,232,231);
                $pdf->Cell(190,10,utf8_decode('- No hay Permisos para mostrar -'),1,0,'C','true',0);
                $pdf->Ln();
            }else{
                //Mostrando los permisos usados
                foreach($permisos as $permiso){
                    $pdf->SetFont('Arial','B',12);
                    $pdf->setFillColor(231,232,231);
                    $pdf->Cell(190,10,utf8_decode('Permiso N.'.($i+1)),1,0,'C','true',0);
                    $pdf->Ln();
                    
                    //Fila Clave del Permiso
                    $pdf->SetFont('Arial','B',12);
                    $pdf->setFillColor(231,232,231);
                    $pdf->Cell(80,10,utf8_decode('Clave del Permiso   '),1,0,'R','true',0);
                    
                    $pdf->SetFont('Arial','',12);
                    $pdf->setFillColor(255,255,255);
                    $pdf->Cell(110,10,utf8_decode('   '.$permiso->id_permiso),1,0,'L','true',0);
                    $pdf->Ln();
                    
                    //Fila Fecha de Ausento
                    $pdf->SetFont('Arial','B',12);
                    $pdf->setFillColor(231,232,231);
                    $pdf->Cell(80,10,utf8_decode('Fecha de Ausento   '),1,0,'R','true',0);
                    
                    $pdf->SetFont('Arial','',12);
                    $pdf->setFillColor(255,255,255);
                    $pdf->Cell(110,10,utf8_decode('   '.$permiso->fecha_ausento),1,0,'L','true',0);
                    
                    $pdf->SetTextColor(0,0,0);
                    $pdf->Ln();
                    $pdf->Ln();
                    
                    $i++;
                }
                //Mostrando el o los meses mas Usados
                $mesesMasUsados = CPermiso::mesMasSolicitado($docente->id_docente);

                if(empty($mesesMasUsados)){
                    $pdf->SetFont('Arial','B',12);
                    $pdf->setFillColor(231,232,231);
                    $pdf->Cell(80,20,'Mes mas solicitado:   ',1,0,'R','true',0);
                    $pdf->SetFont('Arial','',12);
                    $pdf->SetTextColor(118,118,118);
                    $pdf->setFillColor(255,255,255);
                    $pdf->Cell(110,20,'   Ninguno',1,0,'L','true',0);
                }else if(count($mesesMasUsados)==1){
                    $pdf->SetFont('Arial','B',12);
                    $pdf->setFillColor(231,232,231);
                    $pdf->Cell(80,20,'Mes mas solicitado:   ',1,0,'R','true',0);
                    $pdf->SetFont('Arial','',12);
                    $pdf->setFillColor(255,255,255);
                    $pdf->Cell(110,20,'   '.$meses[$mesesMasUsados[0]],1,0,'L','true',0);
                }else{
                    $pdf->SetFont('Arial','B',12);
                    $pdf->setFillColor(231,232,231);
                    $pdf->Cell(80,20,'Meses mas solicitados:   ',1,0,'R','true',0);
                    $pdf->SetFont('Arial','',12);
                    $pdf->setFillColor(255,255,255);
                    if(count($mesesMasUsados)==2){
                        $pdf->Cell(110,20,'   '.$meses[$mesesMasUsados[0]].' y '.$meses[$mesesMasUsados[1]],1,0,'L','true',0);
                    }else if(count($mesesMasUsados)==3){
                        $pdf->Cell(110,20,'   '.$meses[$mesesMasUsados[0]].', '.$meses[$mesesMasUsados[1]].' y '.$meses[$mesesMasUsados[2]],1,0,'L','true',0);
                    }else if(count($mesesMasUsados)==4){
                        $pdf->Cell(110,20,'   '.$meses[$mesesMasUsados[0]].', '.$meses[$mesesMasUsados[1]].', '.$meses[$mesesMasUsados[2]].' y '.$meses[$mesesMasUsados[3]],1,0,'L','true',0);
                    }       
                }    
                    
            }
            $pdf->SetTextColor(0,0,0);
        }
    }
    //Dando nombre al Documento
    if(isset($_GET['todos']) && !empty($_GET['todos']) && $_GET['todos']==1){
        //Reporte General
        $pdf->Output('I','ReporteGeneralPermisos.pdf','true');
    }else{
        //Reporte Individual
        $pdf->Output('I',$docente->id_docente.'_'.$docente->apellido_pat.'_'.$docente->apellido_mat.'_ReportePermisos.pdf','true');
    }
}
?>
