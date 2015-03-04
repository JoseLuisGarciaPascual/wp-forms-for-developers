<?php

function create_form_submenu_page() {
	add_submenu_page( 'forms-for-developers', 'Crear Formulario', 'Crear Formulario', 'manage_options', 'ffd-form-create', 'form_create_callback' );
}

function form_create_callback (){
    ?>
<div class="wrap">
    <h2>
            Crear Formulario
    </h2>
    <form method="post" action="<?php menu_page_url( 'forms-for-developers', true ); ?>">
        <input type="hidden" name="origin" value="create" />
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label>Nombre:</label>
                    </th>
                    <td>
                        <input type="text" name="name" placeholder="Nombre del formulario" class="regular-text"/>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label>Tipo de Respuesta:</label>
                    </th>
                    <td>
                        <select name="response" class="regular-text" id="response_option">
                            <option value="ajax">AJAX</option>
                            <option value="http">Redirección HTTP</option>
                        </select>
                    </td>
                </tr>    
                <tr id="response_url" style="display: none;">
                    <th scope="row">
                        <label>URL:</label>
                    </th>
                    <td>
                        <input type="text" name="url_redirect" placeholder="URL de redireccion" class="regular-text"/>
                    </td>
                </tr>
                <tr id="response_ajax">
                    <th scope="row">
                        <label>AJAX:</label>
                    </th>
                    <td>
                        <span>La funcion de submit realizara un respuesta de TRUE o FALSE para ser capturada por AJAX</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label>Campos:</label>
                    </th>
                    <td>
                        <input type="button" name="submit" class="button new_row" value="Añadir Campo">
                    </td>
                </tr>
                
                <tr class="fields_row" id="1">
                    <th scope="row">
                        <label>Campo 1</label>
                    </th>
                    <td>
                        <input type="text" name="field_labels[]" placeholder="Nombre Publico" class="regular-text"/>
                    </td>
                    <td>
                        <input type="text" name="field_names[]" placeholder="Nombre interno (atributo name)" class="regular-text"/>
                    </td>
                    <td>
                        <span>Tipo de Campo</span>
                    </td>
                    <td>
                        <select name="field_types[]" class="regular-text">
                            <option value="email">Email</option>
                            <option value="text">Texto</option>
                        </select>
                    </td>
                    <td>
                        <label>¿Obligatorio?</label>
                    </td>
                    <td>
                        <select name="required_fieds[]" class="regular-text">
                            <option value="0">No</option>
                            <option value="1">Si</option>
                        </select>
                    </td>
                    <td>
                        <input type="button" name="delete" class="button delete_row" value="Borrar Campo">
                    </td>
                </tr> 
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" id="submit" class="button button-primary" value="Crear Formulario">
        </p>
    </form>
</div>
<!--Hidden Content -->
<table style="display: none">
    <tr class="fields_row_empy">
                    <th scope="row">
                        <label>Campo</label>
                    </th>
                    <td>
                        <input type="text" name="field_labels[]" placeholder="Nombre Publico" class="regular-text"/>
                    </td>
                    <td>
                        <input type="text" name="field_names[]" placeholder="Nombre interno (atributo name)" class="regular-text"/>
                    </td>
                    <td>
                        <span>Tipo de Campo</span>
                    </td>
                    <td>
                        <select name="field_types[]" class="regular-text">
                            <option value="email">Email</option>
                            <option value="text">Texto</option>
                        </select>
                    </td>
                    <td>
                        <label>¿Obligatorio?</label>
                    </td>
                    <td>
                        <select name="required_fieds[]" class="regular-text">
                            <option value="0">No</option>
                            <option value="1">Si</option>
                        </select>
                    </td>
                    <td>
                        <input type="button" name="delete" class="button delete_row" value="Borrar Campo">
                    </td>
                </tr>
</table>
        <?php
}