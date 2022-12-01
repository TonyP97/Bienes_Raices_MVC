<?php foreach($entradas as $entrada) { ?>

<article class="entrada-blog">
    <div class="imagen">
        <picture>
            <img loading="lazy" src="/imagenes/<?php echo $entrada->imagen; ?>" alt="Anuncio">
        </picture>
    </div>

    <div class="texto-entrada">
        <a href="/entrada?id=<?php echo $entrada->id; ?>">
            <h4><?php echo $entrada->titulo; ?></h4>
            <p class="informacion-meta">Escrito el: <span><?php echo $entrada->fecha; ?></span> por: <span><?php echo $entrada->autor; ?></span></p>

            <p><?php echo substr($entrada->texto, 0, 40); ?>...</p>
        </a>
    </div>
</article>
<?php } ?>