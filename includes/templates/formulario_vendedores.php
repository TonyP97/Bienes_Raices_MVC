<fieldset>
    <legend>Información General</legend>

    <label for="nombre">Nombre:</label>
    <input 
    type="text" 
    id="nombre" 
    placeholder="Nombre Vendedor(a)" 
    name="vendedor[nombre]" 
    value="<?php echo sanitizar($vendedor->nombre); ?>">

    <label for="apellido">Apellido:</label>
    <input 
    type="text" 
    id="apellido" 
    placeholder="Apellido Vendedor(a)" 
    name="vendedor[apellido]" 
    value="<?php echo sanitizar($vendedor->apellido); ?>">
</fieldset>

<fieldset>
    <legend>Información Extra</legend>

    <label for="telefono">Teléfono:</label>
    <input 
    type="text" 
    id="telefono" 
    placeholder="Teléfono Vendedor(a)" 
    name="vendedor[telefono]" 
    value="<?php echo sanitizar($vendedor->telefono); ?>">
</fieldset>