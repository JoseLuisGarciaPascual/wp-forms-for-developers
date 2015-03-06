<?php
require( dirname(__FILE__) . '/../../../wp/wp-load.php' );
require_once("/lib/bbdd.php");

function edit_form_submenu_page() {
	add_submenu_page( null , 'Editar Formulario', 'Editar fFormulario', 'manage_options', 'ffd-form-edit', 'form_edit_callback' );
}

function form_edit_callback (){
    $form_id = $_REQUEST['id'];
    ?>
    <div class="wrap">
        <h2>
            Editando Formulario (ID: <?php echo $form_id ?>)
        </h2>    
    <?php
    if ( $_POST['origin'] === 'edit'){
        
        $name = $_POST['name'];
        $response = ($_POST['response'] === 'ajax') ? 'ajax' : $_POST['url_redirect'];
        $field_labels = $_POST['field_labels'];
        $field_names  = $_POST['field_names'];
        $field_types = $_POST['field_types'];
        $field_reqs = $_POST['required_fieds'];
        
        $total_fields = count($field_names);
        $update_fields = array();
        
        for ($i = 0; $i < $total_fields; $i++){
            $fields[$field_names[$i]] = array(
                'label'     => $field_labels[$i],
                'type'      => $field_types[$i],
                'required'  => $field_reqs[$i]
            );
            
        }
        
        $update_fields = json_encode($fields);
        
        if(ffd_form_update($form_id, $update_fields, $response)){
            ?>
            <div class="updated">
                <p><?php _e( 'Formulario Editado con exito', 'ffd-plugin' ); ?></p>
            </div>
            <?php
        }else{
            ?>
            <div class="error">
                <p><?php _e( 'Ha ocurrido un error al crear el formulario', 'ffd-plugin' ); ?></p>
            </div>
            <?php
        }
    }
    
    $BBDD_headers = ffd_get_headers($form_id);
    $fields = json_decode($BBDD_headers[0]->fields);
    $form = ffd_get_form($form_id);
    $response = $form[0]->response;
    ?>
        
        <form method="post" action="<?php menu_page_url( 'ffd-form-edit', true ); ?>">
            <input type="hidden" name="origin" value="edit" />
            <input type="hidden" name="id" value="<?php echo $form_id; ?>" />
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label>Tipo de Respuesta:</label>
                        </th>
                        <td>
                            <select name="response" class="regular-text" id="response_option">
                                <?php if ($response === 'ajax'): ?>
                                    <option value="ajax" selected>AJAX</option>
                                    <option value="http">Redirección HTTP</option>
                                <?php else : ?>
                                    <option value="ajax">AJAX</option>
                                    <option value="http" selected>Redirección HTTP</option>
                                <?php endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr id="response_url" <?php  if ($response === 'ajax'): ?> style="display: none;" <?php endif;?>>
                    
                        <th scope="row">
                            <label>URL:</label>
                        </th>
                        <td>
                            <input type="text" name="url_redirect" placeholder="URL de redireccion" value="<?php  if ($response !== 'ajax'){ echo $response;}?>" class="regular-text"/>
                        </td>
                    </tr>
                    <tr id="response_ajax"<?php  if ($response !== 'ajax'): ?> style="display: none;" <?php endif;?>>
                        <th scope="row">
                            <label>AJAX:</label>
                        </th>
                        <td>
                            <span>La funcion de submit realizara un respuesta de TRUE o FALSE para ser capturada por AJAX</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="button" name="submit" class="button new_row" value="Añadir Campo">
                        </td>
                    </tr>
                    <?php $i = 0; ?>
                    <?php foreach ($fields as $key => $field): ?>
                        <tr class="fields_row" id="<?php echo ++$i; ?>">
                            <input type="hidden" name="field_names[]" value="<?php echo $key ?>" />
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
            <p class="submit">
                <input type="submit" id="submit" class="button button-primary" value="Actualizar Formulario">
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