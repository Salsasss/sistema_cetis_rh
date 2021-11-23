//Funcion que valida los datos de entrada a la hora de registrar un Docente
function validarDatosDocente() {
    const formulario = document.querySelector('.formulario.datos');
    if (formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault();
            mensaje = '';
            tiposPermitidos = /(.pdf|.jpeg|.jpg|.png)$/i;

            //Validando el nombre
            const nombre = document.getElementById('nombre');
            mensaje += comprobarLongitud(nombre.value, 3, 100, 'El Nombre');
            mensaje += comprobarTexto(nombre.value, 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóúÁÉÍÓÚ. ', 'El Nombre');

            //Validando el apellido paterno
            const apellido_pat = document.getElementById('apellido_pat');
            mensaje += comprobarLongitud(apellido_pat.value, 3, 100, 'El Apellido Paterno');
            mensaje += comprobarTexto(apellido_pat.value, 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóúÁÉÍÓÚ. ', 'El Apellido Paterno');

            //Validando el apellido materno
            const apellido_mat = document.getElementById('apellido_mat');
            mensaje += comprobarLongitud(apellido_mat.value, 3, 100, 'El Apellido Materno');
            mensaje += comprobarTexto(apellido_mat.value, 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóúÁÉÍÓÚ. ', 'El Apellido Materno');

            //Validando el sexo
            const sexo = document.getElementById('sexo');
            if (sexo.value != 'Masculino' && sexo.value != 'Femenino') {
                mensaje += '<li> Sexo No v&aacute;lido <br> </li>';
            }

            //Validando fecha de nacimiento
            const fecNac = document.getElementById('fecha_nac');
            if (fecNac.value == '') {
                mensaje += '<li> La fecha de nacimiento es Obligatoria <br> </li>';
            }
            const fecha = new Date(fecNac.value);
            const edad2 = calculaEdad(fecha);
            if (edad2 < 21) {
                mensaje += '<li> El minimo de edad requerido son 21 a&ntildeos <br> </li>';
            }

            //Validando el celular
            const celular = document.getElementById('celular');
            mensaje += comprobarLongitud(celular.value, 12, 12, 'El celular');
            mensaje += comprobarTexto(celular.value, '1234567890-', 'El celular');

            //Validando documento acta de Nacimiento
            if (document.querySelector('.submit').value == 'Registrar Docente') {
                const actNac = document.getElementById('file_acta');
                if (actNac.value) {
                    if (!tiposPermitidos.exec(actNac.value)) {
                        //si .pdf no se encuentra en la ruta del documento
                        mensaje += '<li> El Acta de Nacimiento debe ser .pdf <br></li>'
                    }
                    if (actNac.files[0].size > 3145728) {
                        //si el documento pesa mas de 3MB
                        mensaje += '<li> El Acta de Nacimiento es muy pesado. Max: 3MB <br></li>'
                    }
                } else {
                    mensaje += '<li> El Acta de Nacimiento es Obligatorio <br></li>'
                }
            }

            //Validando la curp
            const curp = document.getElementById('curp');
            mensaje += comprobarLongitud(curp.value, 18, 18, 'El CURP');
            mensaje += comprobarTexto(curp.value, 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890 ', 'El CURP');
            if (curpValida(curp.value) != true) {
                mensaje += '<li> CURP No Valida: No reconocida<br> </li>';
            }

            //Validando documento CURP
            if (document.querySelector('.submit').value == 'Registrar Docente') {
                const fileCurp = document.getElementById('file_curp');
                if (fileCurp.value) {
                    if (!tiposPermitidos.exec(fileCurp.value)) {
                        //si .pdf no se encuentra en la ruta del documento
                        mensaje += '<li> El Documento CURP debe ser .pdf <br></li>'
                    }
                    if (fileCurp.files[0].size > 3145728) {
                        //si el documento pesa mas de 3MB
                        mensaje += '<li> El Documento CURP es muy pesado. Max: 3MB <br></li>'
                    }
                } else {
                    mensaje += '<li> El Documento CURP es Obligatorio <br></li>'
                }
            }

            //Validando el nss
            const nss = document.getElementById('nss');
            mensaje += comprobarLongitud(nss.value, 11, 11, 'El NSS');
            mensaje += comprobarTexto(nss.value, '1234567890 ', 'El NSS');
            if (!nssValido(nss.value)) {
                mensaje += '<li> NSS No v&aacute;lido: No reconocido <br> </li>';
            }

            //Validando el documento NSS
            if (document.querySelector('.submit').value == 'Registrar Docente') {
                const fileNss = document.getElementById('file_nss');
                if (fileNss.value) {
                    if (!tiposPermitidos.exec(fileNss.value)) {
                        //si .pdf no se encuentra en la ruta del documento
                        mensaje += '<li> El Documento NSS debe ser .pdf <br></li>'
                    }
                    if (fileNss.files[0].size > 3145728) {
                        //si el documento pesa mas de 3MB
                        mensaje += '<li> El Documento NSS es muy pesado. Max: 3MB <br></li>'
                    }
                } else {
                    mensaje += '<li> El Documento NSS es Obligatorio <br></li>'
                }
            }

            //Validando el rfc
            const rfc = document.getElementById('rfc');
            mensaje += comprobarLongitud(rfc.value, 13, 13, 'El RFC');
            mensaje += comprobarTexto(rfc.value, 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890 ', 'El RFC');
            if (rfcValida(rfc.value) != true) {
                mensaje += '<li> RFC no V&aacute;lido: No reconocido <br> </li>';
            }

            if (document.querySelector('.submit').value == 'Registrar Docente') {
                //validando el documento Rfc        
                const fileRfc = document.getElementById('file_rfc');
                if (fileRfc.value) {
                    if (!tiposPermitidos.exec(fileRfc.value)) {
                        //si .pdf no se encuentra en la ruta del documento
                        mensaje += '<li> El Documento RFC debe ser .pdf <br></li>'
                    }
                    if (fileRfc.files[0].size > 3145728) {
                        //si el documento pesa mas de 3MB
                        mensaje += '<li> El Documento RFC es muy pesado. Max: 3MB <br></li>'
                    }
                } else {
                    mensaje += '<li> El Documento RFC es Obligatorio <br></li>'
                }
            }

            //Validando grado de estudios
            const grado = document.getElementById('grado_estudios');
            if (grado.value != 'Universidad' && grado.value != 'Maestria' && grado.value != 'Doctorado') {
                mensaje += '<li> Grado de Estudios No V&aacute;lida <br> </li>';
            }

            //Validando horas por plaza
            const horas = document.getElementById('horas_plaza');
            if (horas.value < 5) {
                mensaje += '<li> Horas minimas por plaza: 5 Horas <br> </li>';
            } else if (horas.value > 40) {
                mensaje += '<li> Horas m&aacute;ximas por plaza: 40 Horas <br> </li>';
            }
            if (horas.value >= 30 && (grado.value != 'Maestria' && grado.value != 'Doctorado')) {
                mensaje += '<li> Para plazas de 30 Horas o m&aacute;s el Grado de Estudios m&iacute;nimo es: Maestria <br> </li>';
            }

            //Validando si el mensaje es de error o no
            if (mensaje == '') {
                //Si se esta dando de alta
                if (document.querySelector('.submit').value == 'Registrar Docente') {
                    mostrarAlerta('¡Docente Dado de Alta Correctamente!');
                } else {
                    //Si se esta dando editando informacion
                    mostrarAlerta('¡Datos Actualizados Correctamente!');
                }

                //Despues de 2 segundos hace desaparecer el mensaje
                setTimeout(() => {
                    formulario.submit();
                }, 2000)
            } else {
                //Mensaje de Error
                mostrarAlerta(mensaje, 'ERROR');
            }
            return;
        });
    }
}

validarDatosDocente();