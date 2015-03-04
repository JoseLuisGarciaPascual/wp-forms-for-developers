<?php
require( dirname(__FILE__) . '/../../../wp/wp-load.php' );
require_once("/lib/bbdd.php");

function edit_form_submenu_page() {
	add_submenu_page( null , 'Editar Formulario', 'Editar fFormulario', 'manage_options', 'ffd-form-edit', 'form_edit_callback' );
}

function form_edit_callback (){
    $form_id = $_GET['id'];
    ?>
    <div class="wrap">
        <h2>
            Editando Formulario (ID: <?php echo $form_id ?>)
        </h2>    
    <?php
    $BBDD_headers = ffd_get_headers($form_id);
    $fields = json_decode($BBDD_headers[0]->fields);
    ?>
        
        <form method="post" action="<?php menu_page_url( 'forms-for-developers', true ); ?>">
            <input type="hidden" name="origin" value="edit" />
            <table class="form-table">
                <tbody>
                    <tr>
                        <td>
                            <input type="button" name="submit" class="button new_row" value="Añadir Campo">
                        </td>
                    </tr>
                    <?php $i = 0; ?>
                    <?php foreach ($fields as $key => $field): ?>
                        <tr class="fields_row" id="<?php echo ++$i; ?>">
                            <th scope="row">
                                <label>Campo [<?php echo $key ?>]</label>
                            </th>
                            <td>
                                <input type="text" name="field_labels[]" class="regular-text" value="<?php echo $field->label; ?>"/>
                            </td>
                            <td>
                                <span>Tipo de Campo</span>
                            </td>
                            <td>
                                <select name="field_types[]" class="regular-text">
                                    <?php if($field->type === "email"): ?>
                                        <option value="email" selected>Email</option>
                                        <option value="text">Texto</option>
                                    <?php else : ?>
                                        <option value="email">Email</option>
                                        <option value="text" selected>Texto</option>
                                    <?php endif; ?>
                                </select>
                            </td>
                            <td>
                                <label>¿Obligatorio?</label>
                            </td>
                            <td>
                                <select name="required_fieds[]" class="regular-text" value="<?php echo $field->required; ?>">
                                    <?php if($field->required): ?>
                                        <option value="0">No</option>
                                        <option value="1" selected>Si</option>
                                    <?php else : ?>
                                        <option value="0" selected>No</option>
                                        <option value="1">Si</option>
                                    <?php endif; ?>
                                </select>
                            </td>
                            <td>
                                <input type="button" name="delete" class="button delete_row" value="Borrar Campo">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>    
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