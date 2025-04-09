<?php
session_start();
include "../Class/Class.php";

$hdc = new HDC();

if ($_REQUEST['ajax_name'] == 'hdc') {
    $result = $hdc->get_hdc_all();
    var_dump($result);
    // foreach($result as $row){
    //     $data[] = array(
    //         'hdc_id' => $row['hdc_id'],
    //         'name'=> $row['titlename'].$row['firstname']." ".$row['lastname'],
    //         ''
    //     );
    // }
}
?>