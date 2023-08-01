<?php 
$conn=mysqli_connect("localhost","root","","asdp_kupang");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
