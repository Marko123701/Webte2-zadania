<?php
$input = json_decode(file_get_contents('php://input'), true);
$var1 = $input['var1'];
$var2 = $input['var2'];

echo json_encode("$var1 $var2");
?>