<?php

include('config.php');
$id = $_POST['id'];
$intid = intval($id);

$query = "SELECT * FROM videos WHERE id = $intid";
$result = mysqli_query($conn, $query);
echo json_encode(mysqli_fetch_assoc($result))


?>