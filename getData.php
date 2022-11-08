<?php
require_once 'connect.php';

if(isset($_POST['user_id'])){
    $uid = $_POST['user_id'];

    $sql = $conn->query("select  SUM(cal) AS sumCal, u.firstName, u.weight, u.height, u.lastname, u.level, u.age, u.rfid, p.name, p.protein, p.carbo, p.vitamin, p.fat, p.cal , p.sodium from products_line pl join products p ON p.id = pl.products_id join user u ON u.user_id = pl.user_id join parent pt ON pt.parentID = u.parent_parentID  WHERE line_user_id = '$uid'");

    if($sql) {
        $result = $sql->fetchAll();
        echo json_encode($result[0]);
    }
}

?>