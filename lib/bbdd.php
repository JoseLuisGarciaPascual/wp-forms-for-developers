<?php

function ffd_database_install () {
    global $wpdb;
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    $charset_collate = $wpdb->get_charset_collate();
    /**
    * Install forms Table
    */
	$forms_table = $wpdb->prefix . 'ffd_forms';
	

	$sql = "CREATE TABLE IF NOT EXISTS $forms_table (
        `id` INT NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(45) NULL,
        `fields` TEXT NULL,
        `response` VARCHAR(45) NULL,
        PRIMARY KEY  (`id`)
	) $charset_collate;";

	dbDelta( $sql );
    /**
    * Install Value Table
    */
    $values_table = $wpdb->prefix . 'ffd_data';

	$sql = "CREATE TABLE IF NOT EXISTS $values_table (
        `id` INT NOT NULL AUTO_INCREMENT,
        `values` TEXT NULL,
        `form_id` INT NOT NULL,
        `submit_date` DATETIME NOT NULL,
        PRIMARY KEY  (`id`),
        INDEX `fk_".$values_table."_".$forms_table."_idx` (`form_id` ASC),
        CONSTRAINT `fk_".$values_table."_".$forms_table."`
          FOREIGN KEY (`form_id`)
          REFERENCES $forms_table (`id`)
          ON DELETE NO ACTION
    ON UPDATE NO ACTION
	) $charset_collate;";

	dbDelta( $sql );
}

function ffd_form_create ($formName, $formFields, $formResponse) {
    global $wpdb;
    
    $forms_table = $wpdb->prefix . 'ffd_forms';
    
    return $wpdb->insert( 
        $forms_table, 
        array( 
            'name' => $formName, 
            'fields' => $formFields,
            'response' => $formResponse
        )
    );
}

function ffd_form_update ($formID, $formFields, $formResponse) {
    global $wpdb;
    
    $forms_table = $wpdb->prefix . 'ffd_forms';
    
    return $wpdb->update( 
        $forms_table, 
        array( 
            'fields' => $formFields,
            'response' => $formResponse
        ),
        array( 'id' => $formID ) 
    );
}

function ffd_get_form ( $form_id ){
    global $wpdb;
    
    $forms_table = $wpdb->prefix . 'ffd_forms';
    
    $query = "SELECT fields, response "
        . "FROM $forms_table "
        . "where id=$form_id;";
    
    return $wpdb->get_results($query);
}

function ffd_set_data ($form_id, $data){
    global $wpdb;
    
    $data_table = $wpdb->prefix . 'ffd_data';
    
    return $wpdb->insert( 
        $data_table, 
        array( 
            'form_id' => $form_id,
            'values' => $data,
            'submit_date' => date('Y-m-d H:i:s')
        )
    );
}

function ffd_delete_form($form_id){
    global $wpdb;
    
    $forms_table = $wpdb->prefix . 'ffd_forms';
    
    $data_table = $wpdb->prefix . 'ffd_data';
    
    $form_result = $wpdb->delete( $forms_table, array( 'id' => $form_id ) );
    
    $submits_count = $wpdb->get_var( "SELECT COUNT(*) FROM $data_table where form_id =$form_id" );
    
    if ($submits_count > 0){
        $data_result = $wpdb->delete( $data_table, array( 'form_id' => $form_id ) );
    }else{
        $data_result = true;
    }
    
    if ($form_result && $data_result){
        return true;
    }else{
        return false;
    }
}

function ffd_get_headers ( $form_id ){
    global $wpdb;
    
    $data_table = $wpdb->prefix . 'ffd_forms';
    
    $query = "SELECT fields FROM $data_table where id=$form_id";
    
    return $wpdb->get_results($query);
}