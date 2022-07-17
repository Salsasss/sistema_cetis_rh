//Funcion que oculta o muestra la navegacion en la version Mobil
function mostrarNavegacion() {
    const menu = document.querySelector('.iconos-menu');
    menu.addEventListener('click', function() {
        const navegacion = document.querySelector('.barra-opciones');
        if (navegacion.classList.contains('visible')) {
            navegacion.classList.remove('visible');
        } else {
            navegacion.classList.add('visible');
        }
    });
}
mostrarNavegacion();