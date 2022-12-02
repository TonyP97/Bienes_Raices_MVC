document.addEventListener('DOMContentLoaded', function() {
    eventListener();

    darkMode();
}) ;

function eventListener() {
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive);

    // Muestra campos condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]');
    metodoContacto.forEach( input => input.addEventListener('click', mostrarMetodoContacto) );
};

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');

    if(navegacion.classList.contains('mostrar')) {
        navegacion.classList.remove('mostrar');
    } else {
        navegacion.classList.add('mostrar');
    }
}

function mostrarMetodoContacto(e) {
    const contactoDiv = document.querySelector('#contacto');
    if(e.target.value === 'telefono') {
        contactoDiv.innerHTML = `
            <label for="telefono">Número de teléfono</label>
            <input type="tel" placeholder="Tu Teléfono" id="telefono" name="contacto[telefono]">

            <p>Elija la fecha y la hora en la que desea que lo llamen.</p>
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="contacto[fecha]">

            <label for="hora">Hora</label>
            <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]">
        `;
        return;
    }
    contactoDiv.innerHTML = `
        <label for="email">E-mail</label>
        <input type="email" placeholder="Tu Email" id="email" name="contacto[email]" required>
    `;
}

function darkMode() {

    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
    // console.log(prefiereDarkMode.matches);
    if(prefiereDarkMode.matches) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }

    prefiereDarkMode.addEventListener('change', function() {
        if(prefiereDarkMode.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    })

    const darkModeBtn = document.querySelector('.dark-mode-boton');
    darkModeBtn.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode'); // toggle agrega la clase si no la tiene y la quita si la tiene
    });
}

function showPasswd() {
    var x = document.getElementById("password");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }