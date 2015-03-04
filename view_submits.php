<?php
require( dirname(__FILE__) . '/../../../wp/wp-load.php' );
require_once("/lib/bbdd.php");
require_once("/lib/csv.php");
require_once("/lib/class-submits-list-table.php");

function view_submits_submenu_page() {
	add_submenu_page( null , 'Ver Registros', 'Ver Registros', 'manage_options', 'ffd-form-submits', 'form_submits_callback' );
}

function form_submits_callback (){
    $form_id = $_GET['id'];
    $max_elements = $_GET['max_elements'];
    $date_start = $_GET['date_start'];
    $date_end = $_GET['date_end'];
    ?>
    <div class="wrap">
        <h2>
            Registros de Formulario (ID: <?php echo $form_id ?>)
        </h2>
        <?php
        $BBDD_headers = ffd_get_headers($form_id);
        $headers = json_decode($BBDD_headers[0]->fields);

        if($headers ){
            $html_table_header = "<tr>";
            foreach ($headers as $header){
                $html_table_header .= "<th scope='col'><span>$header->label</span></th>";
            }
            $html_table_header .= "<th scope='col'>Fecha<span></span></th></tr>";
            
            ?>
            <form method="get" action="<?php menu_page_url( 'ffd-form-submits', true ); ?>">
                <table class="form-table">
                    <input type="hidden" name="id" value="<?php echo $form_id; ?>" class="regular-text"/>
                    <input type="hidden" name="page" value="ffd-form-submits" class="regular-text"/>
                    <tbody>
                        <tr>
                            <td>
                                <label><strong>Filtros:</strong></label>
                            </td>
                            <td>
                                <label>Maximo de elementos:</label>
                            </td>
                            <td>
                                <input type="text" name="max_elements" class="regular-text"/>
                            </td>
                            <td>
                                <label>Entre Fechas:</label>
                            </td>
                            <td>
                                <input type="date" name="date_start" class="regular-text"/>
                            </td>
                            <td>
                                <input type="date" name="date_end" class="regular-text"/>
                            </td>
                            <td>
                                <input type="submit" id="submit" class="button" value="Aplicar Filtros">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        
            <form method="get" action="<?php echo plugins_url( '/export.php' , __FILE__ ); ?>">
                <input type="hidden" name="action" value="Download" class="regular-text"/>
                <input type="hidden" name="id" value="<?php echo $form_id; ?>" class="regular-text"/>
                <input type="hidden" name="page" value="ffd-form-submits" class="regular-text"/>
                <input type="hidden" name="max_elements" value="<?php echo $max_elements; ?>" class="regular-text"/>
                <input type="hidden" name="date_start" value="<?php echo $date_start; ?>" class="regular-text"/>
                <input type="hidden" name="date_end" value="<?php echo $date_end; ?>" class="regular-text"/>
                    <tbody>
                        <input type="submit" id="submit" class="button button-primary" value="Descargar estos datos como CSV">
                    </tbody>
                </table>
            </form>
        
            <table class="wp-list-table widefat fixed">
                <thead>
                    <?php echo $html_table_header;?>
                </thead>
                <tfoot>
                    <?php echo $html_table_header;?>
                </tfoot>
                <tbody id="the-list">
                    <?php 
                        $list = new Submit_List_Table();
                        $list->prepare_items( $form_id, $max_elements, $date_start, $date_end );
                        $list->display_submit_list();
                    ?>
                </tbody>
            </table>

            <?php
        }else {
            _e('Este formulario no tiene registros','ffd-admin');
        }
}