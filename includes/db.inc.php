<?php  
  $config = parse_ini_file('../../../private/db-config.ini');
  $conn = new mysqli($config['servername'], $config['username'], $config['password'],$config['dbname']);

  if(!$conn) {
    header("location: ../index.php?error=sqlconnfailed");
    die("Connection failed: ". mysqli_connect_error());
  }
?>