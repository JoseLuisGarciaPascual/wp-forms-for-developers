<?php
require( dirname(__FILE__) . '/../../../wp/wp-load.php' );
require_once("/lib/bbdd.php");
require_once("/lib/csv.php");
require_once("/lib/class-submits-list-table.php");

$form_id = $_GET['id'];
$max_elements = $_GET['max_elements'];
$date_start = $_GET['date_start'];
$date_end = $_GET['date_end'];

$list = new Submit_List_Table();
$list->prepare_items( $form_id, $max_elements, $date_start, $date_end );
$csv_array = $list->array_submit_list();
download_headers("data_export_" . date("Y-m-d") . ".csv");
echo arraytocsv($csv_array);
exit();