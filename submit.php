<?php
require( dirname(__FILE__) . '/../../../wp/wp-load.php' );
require_once("/lib/bbdd.php");

$form_id = $_REQUEST['id'];

$form_options = ffd_get_form($form_id);
$form_options = $form_options[0];

$fields = json_decode($form_options->fields);
$data = array();
$result_msg = array();
foreach ($_REQUEST as $key=>$value){
    if (array_key_exists($key, $fields)){
        if($fields->$key->required){
            if (empty($_REQUEST[$key])): $result_msg['error'] = true; $result_msg['error_msgs'] .= "El campo $key es obligatorio.<br />" ; endif;
        }
        switch ($fields->$key->type){
            case 'text': 
                $data[$key] = strip_tags($value);
                break;
            case 'email': 
                $data[$key] = sanitize_email($value);
                break;        
        }
    }
}

if ( empty($result_msg)){
    $data_json = json_encode($data);
    if (ffd_set_data($form_id, $data_json)){
        if ($form_options->response === 'ajax'){
            echo '1';
        }else{
            header ("Location: $form_options->response");
        }
    }else{
        if ($form_options->response === 'ajax'){
            echo '0';
        }else{
            header ("Location: $form_options->response?error=BBDD");
        }
    }
}else{
    if ($form_options->response === 'ajax'){
            echo 'Field Error';
        }else{
            header ("Location: $form_options->response?error=" .$result_msg['error_msgs']);
        }
}