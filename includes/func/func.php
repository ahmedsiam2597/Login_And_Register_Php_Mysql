<?php


function show_error($error){
    if(isset($error)){
        echo $error;
    }
    return;
}
function row_count( $name, $table,$value){
    global $db;
    $stmt = $db->prepare("SELECT $name FROM $table where $name = :v ");
    $stmt->execute([
        ":v" => $value,
    ]);
    $row = $stmt->rowCount();
    return $row;
}