<?php 

class Submit_List_Table{
    
    /**
    * Prepare the table data
    */
    function prepare_items( $form_id, $max_elements = NULL, $date_start = NULL , $date_end = NULL ) {
        global $wpdb;

        /* -- Preparing your query -- */
        $data_table = $wpdb->prefix . 'ffd_data';
    
        $query = "SELECT d.values, d.submit_date FROM $data_table as d where form_id=$form_id";
        if ( $max_elements || $date_start || $date_end ){
            if ($date_start && $date_end){
                $query .= " AND submit_date BETWEEN '$date_start' AND '$date_end'";
            }
            if ( $max_elements ){
                $query .= " LIMIT $max_elements";
            }
        }
        /* -- Fetch the items -- */
        $this->items = $wpdb->get_results($query);
    }
    
    function display_submit_list(){
        if ( $this->has_items() ) {
			$this->display_rows();
		} else {
			echo '<tr class="no-items"><td class="colspanchange" colspan="3">';
			$this->no_items();
			echo '</td></tr>';
		}
    }
    
    function array_submit_list(){
        $return_array = array();

        if ( $this->has_items() ) {
            $i = 0;
            foreach ($this->items as $item){
                $decoded = json_decode($item->values);
                $j = 0;
                foreach ($decoded as $value){
                    $return_array[$i][$j] = $value;
                    $j++;
                }
                $i++;
            }
            return $return_array;
		} else {
			$this->no_items();
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
        $values = json_decode($item->values);
        Foreach ($values as $value){
            echo '<td>' . $value . '</td>';
        }
        echo '<td>' . date('Y-m-d', strtotime($item->submit_date)) . '</td>';
        echo '</tr>';
 
	}
}

?>