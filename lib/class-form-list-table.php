<?php 

class Form_List_Table{
    
    /**
    * Prepare the table data
    */
    function prepare_items() {
        global $wpdb, $_wp_column_headers;

        /* -- Preparing your query -- */
        $query = "SELECT f.id as id, f.name as name, count(d.values) as submits "
            . "FROM " . $wpdb->prefix . "ffd_forms as f, " . $wpdb->prefix . "ffd_data as d "
            . "where f.id = d.form_id "
            . "group by f.id "
            . "UNION ALL "
            . "SELECT f.id as id, f.name as name, 0 as submits "
            . "FROM " . $wpdb->prefix . "ffd_forms as f, " . $wpdb->prefix . "ffd_data as d "
            . "where f.id != d.form_id "
            . "group by f.id;";

        /* -- Fetch the items -- */
        $this->items = $wpdb->get_results($query);
    }
    
    function display_form_list(){
        if ( $this->has_items() ) {
			$this->display_rows();
		} else {
			echo '<tr class="no-items"><td class="colspanchange" colspan="3">';
			$this->no_items();
			echo '</td></tr>';
		}
    }
    
    function has_items() {
		return !empty( $this->items );
	}
    
    function no_items() {
		_e( 'No items found.' );
	}
    
    /**
	 * Generate the table rows
	 *
	 * @since 0.1
	 * @access protected
	 */
    function display_rows() {
		foreach ( $this->items as $item )
			$this->single_row( $item );
	}
    
    /**
	 * Generates content for a single row of the table
	 *
	 * @since 0.1
	 * @access protected
	 *
	 * @param object $item The current item
	 */
    
    function single_row( $item ) {
		static $row_class = '';
		$row_class = ( $row_class == '' ? ' class="alternate"' : '' );

		echo '<tr' . $row_class . '>';
		$this->single_row_columns( $item );
		echo '</tr>';
	}
    
    /**
	 * Generates the columns for a single row of the table
	 *
	 * @since 0.1
	 * @access protected
	 *
	 * @param object $item The current item
	 */
	function single_row_columns( $item ) {
        
        echo '<tr>';
        echo '<td>'; 
        echo '<strong>' . $item->name . '</strong>';
        ?>
            <div class="row-actions">
                <span class="edit">
                    <a href="<?php menu_page_url( 'ffd-form-edit', true ); ?>&id=<?php echo $item->id ?>" title="Editar este elemento">
                        <?php _e('Editar'); ?>
                    </a> | 
                </span>
                <span class="trash">
                    <a href="<?php menu_page_url( 'forms-for-developers', true ); ?>&delete=<?php echo $item->id ?>" title="Borrar este elemento" class="submitdelete">
                        <?php _e('Borrar'); ?>
                    </a> | 
                </span>
                <span class="view">
                    <a href="<?php menu_page_url( 'ffd-form-submits', true ); ?>&id=<?php echo $item->id ?>" title="Editar">
                        <?php _e('Ver registros'); ?>
                    </a>
                </span>
            </div>
            <?php
        echo '</td>';
        echo '<td>' . $item->id . '</td>';
        echo '<td>' . $item->submits . '</td>';
        echo '</tr>';
 
	}
}

?>