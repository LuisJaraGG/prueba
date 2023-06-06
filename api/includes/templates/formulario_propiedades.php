<fieldset>
    <legend>Informacion general</legend>
    <label for="titulo">Titulo:</label>
    <input type="text" name="propiedad[titulo]" id="titulo" placeholder="Titulo Propiedad" value="<?php echo sanitizarHTML($propiedad->titulo); ?>">


    <label for="precio">Precio:</label>
    <input type="number" name="propiedad[precio]" id="precio" placeholder="Precio Propiedad" value="<?php echo sanitizarHTML($propiedad->precio); ?>">

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" name="propiedad[imagen]" accept="image/jpeg, image/png">

    <?php if ($propiedad->imagen) : ?>
        <img src="../../imagenes/<?php echo $propiedad->imagen ?>" class="imagen-small" alt="<?php echo $propiedad->titulo ?>">
    <?php endif ?>

    <label for="descripcion">Descripcion</label>
    <textarea id="descripcion" name="propiedad[descripcion]"><?php echo sanitizarHTML($propiedad->descripcion); ?></textarea>
</fieldset>

<fieldset>
    <legend>Informacion Propiedad</legend>
    <label for="habitaciones">Habitaciones:</label>
    <input type="number" min="1" max="9" id="habitaciones" name="propiedad[habitaciones]" placeholder="Habitaciones Propiedad" value="<?php echo sanitizarHTML($propiedad->habitaciones) ?>">

    <label for="wc">WC:</label>
    <input value="<?php echo sanitizarHTML($propiedad->wc); ?>" type="number" min="1" max="9" id="wc" name="propiedad[wc]" placeholder="Habitaciones Propiedad">

    <label for="estacionamiento">Estacionamiento:</label>
    <input value="<?php echo sanitizarHTML($propiedad->estacionamiento); ?>" type="number" min="1" max="9" id="estacionamiento" name="propiedad[estacionamiento]" placeholder="Habitaciones Propiedad">

</fieldset>

<fieldset>
    <legend>Vendedor</legend>
    <select name="propiedad[idvendedor]">
        <option value="" disabled selected> --Selecione--</option>
        <?php foreach ($vendedores as $row) : ?>
            <option <?php echo $propiedad->idvendedor === $row->id ? 'selected' : ''; ?> value="<?php echo $row->id; ?>">
                <?php echo sanitizarHTML($row->nombre . " " . $row->apellido); ?>
            </option>
        <?php endforeach; ?>
    </select>

</fieldset>