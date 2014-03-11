<?php
require_once $_SERVER['DOCUMENT_ROOT']."/resources/scripts/classes/backend_class.php";
$Backend = new Backend();
$Backend->submitNotice($_POST["textarea"]);
?>