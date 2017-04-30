<?php
   @session_start();
   include_once '../class/Model.php';
   $data = new Model();
   if (count($_POST) > 0){
       $fullname = $_POST['fullname'];
       $username = $_POST['username'];
       $passwword= $_POST['password'];
       $query = $data->insert(`customer`, array(`username` => ''.$username,`password` => ''.$passwword,`fullname` => ''.$fullname));
       if($query){
           $id = 0;
           $row = $data->get_row("SELECT `id` FROM `customer` WHERE `username`='$username'");
           $id = $row['id'];
           $_SESSION['customer'] = $id;
       }
       header("Location: category.php");
   }