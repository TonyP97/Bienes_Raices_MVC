<main class="contenedor seccion contenido-centrado">
    <h1><?php echo $entrada->titulo; ?></h1>

    <picture>
    <img loading="lazy" src="/imagenes/<?php echo $entrada->imagen; ?>" alt="Anuncio">
    </picture>

    <p class="informacion-meta">Escrito el: <span><?php echo $entrada->fecha; ?></span> por: <span><?php echo $entrada->autor; ?></span></p>

    <div class="resumen-propiedad">

        <p><?php echo $entrada->texto; ?></p>
    </div>
</main>