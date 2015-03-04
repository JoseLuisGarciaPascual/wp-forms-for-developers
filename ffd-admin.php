<?php 
require_once("/lib/class-form-list-table.php");
require_once("/lib/bbdd.php");

function ffd_admin (){
    if ( $_POST['origin'] === 'create'){
        
        $name = $_POST['name'];
        $response = ($_POST['response'] === 'ajax') ? 'ajax' : $_POST['url_redirect'];
        $field_labels = $_POST['field_labels'];
        $field_names  = $_POST['field_names'];
        $field_types = $_POST['field_types'];
        $field_reqs = $_POST['required_fieds'];
        
        $total_fields = count($field_names);
        $fields = array();
        
        for ($i = 0; $i < $total_fields; $i++){
            $fields[$field_names[$i]] = array(
                'label'     => $field_labels[$i],
                'type'      => $field_types[$i],
                'required'  => $field_reqs[$i]
            );
            
        }
        
        $fields = json_encode($fields);
        
        if(ffd_form_create($name, $fields, $response)){
            ?>
            <div class="updated">
                <p><?php _e( 'Formulario Creado con exito', 'ffd-plugin' ); ?></p>
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
    
    if ($_GET['delete']) {
        if(ffd_delete_form($_GET['delete'])){
            ?>
            <div class="updated">
                <p><?php _e( 'Formulario Borrado con exito', 'ffd-plugin' ); ?></p>
            </div>
            <?php
        }else{
            ?>
            <div class="error">
                <p><?php _e( 'Ha ocurrido un error al borrar el formulario', 'ffd-plugin' ); ?></p>
            </div>
            <?php
        }
    }
?>
    <div class="wrap">
        <h2>
            Formularios
            <a href="<?php menu_page_url( 'ffd-form-create', true ); ?>" class="add-new-h2">Añadir nuevo</a>
        </h2>

        <table class="wp-list-table widefat fixed">
            <thead>
                <tr>
                    <th scope="col"><span>Nombre</span></th>
                    <th scope="col"><span>ID</span></th>
                    <th scope="col"><span>Registros</span></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th scope="col"><span>Nombre</span></th>
                    <th scope="col"><span>ID</span></th>
                    <th scope="col"><span>Registros</span></th>
                </tr>
            </tfoot>
            <tbody id="the-list">
                <?php 
                    $list = new Form_List_Table();
                    $list->prepare_items();
                    $list->display_form_list();
                ?>
            </tbody>
        </table>
    </div>
<?php } ?>