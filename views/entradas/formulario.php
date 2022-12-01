<fieldset>
    <legend>Información General</legend>

    <label for="titulo">Título</label>
    <input 
    type="text" 
    id="titulo" 
    placeholder="Título Entrada" 
    name="entrada[titulo]" 
    value="<?php echo sanitizar($entrada->titulo); ?>">

    <label for="imagen">Imagen</label>
    <input 
    type="file" 
    id="imagen" 
    accept="image/jpeg, image/png"
    name="entrada[imagen]">

    <?php if($entrada->imagen): ?>
        <img src="/imagenes/<?php echo $entrada->imagen; ?>" class="imagen-small">
    <?php endif; ?>

    <label for="texto">Texto</label>
    <textarea 
    id="texto" 
    name="entrada[texto]"><?php echo sanitizar($entrada->texto); ?></textarea>
</fieldset>

<fieldset>
    <legend>Autor</legend>

    <label for="autor">Autor</label>
    <input
    type="text"
    id="autor"
    placeholder="Autor"
    name="entrada[autor]"
    value="<?php echo sanitizar($entrada->autor); ?>">
    
</fieldset>