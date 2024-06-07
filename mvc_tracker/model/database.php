<?php
 $dsn = 'mysql:host=localhost:dbname=assignment_tracker';
 $username = 'root';
 // $password = 'pa55word';

 try{

 }catch(PDOException $e){
  $error = "Database Error: ";
  $error .= $e->getMessage();
  include('view/error.php');
  exit();
 }

?>