<?php 
   include_once 'ketnoi.php';
   @session_start();

        if (isset($_POST['fullname'])){
            $fullname = $_POST['fullname'];}else{$fullname = "Khách Hàng"; }
            
        if (isset($_POST['phone'])){
            $phone = $_POST['phone'];}else{$phone = ""; }
            
        if (isset($_POST['address'])){
            $address = $_POST['address'];}else{$address = ""; }
			
		if (isset($_POST['email'])){
            $email = $_POST['email'];}else{$email = "";}
			
		if (isset($_POST['shipping_fullname'])){
            $shipping_fullname = $_POST['fullname'];}else{$shipping_fullname = ""; }
            
        if (isset($_POST['shipping_phone'])){
            $shipping_phone = $_POST['phone'];}else{$shipping_phone = ""; }
            
        if (isset($_POST['shipping_address'])){
            $shipping_address = $_POST['shipping_address'];}else{$shipping_address = ""; }	
   

   if(isset($_SESSION['customer']))
   { 
      checkout_with_login($_SESSION['customer']);
   }else {
      checkout_without_login();
   }


	//hàm thực hiện thanh toán khi không đăng nhập
	function checkout_without_login()
		{
		GLOBAL $connect;
	
		GLOBAL $fullname;
		GLOBAL $phone;
		GLOBAL $email;
		GLOBAL $address;
		GLOBAL $shipping_fullname;
		GLOBAL $shipping_phone ;
		GLOBAL $shipping_address ;
	
			  
				
		//thêm khách hàng mới vào csdl
		 $max_guest_id = mysqli_fetch_row(mysqli_query($connect, "SELECT max(`id`) FROM `guest`"));	  
		 $guest_id=(++$max_guest_id[0]);    
		 insert_guest($guest_id,$fullname,$phone,$address,$email,0);
		  
			  
		//thêm hóa đơn mới vào csdl
		
		$max_order_id = mysqli_fetch_row(mysqli_query($connect, "SELECT max(`id`) FROM `order`"));	  
		$order_id=(++$max_order_id[0]); 
		$total = get_total();
		$rs=insert_order($order_id,$fullname,$phone,$address,$email,$shipping_fullname,$shipping_address,$shipping_phone,$total,$guest_id);
		
		if($rs)
		  {
			inser_cart_detail($order_id);
		   unset($_SESSION['giohang']);  
		   header("Location: Complete.php");
		  }else{
			  echo "Lổi:".mysqli_error($connect);
			  header("Location: 404.php");
			  }
		}
	
	//hàm thực hiện thanh toán đã đăng nhập
	function checkout_with_login($_customer_id)
		{
		GLOBAL $connect;
	
		GLOBAL $fullname;
		GLOBAL $phone;
		GLOBAL $email;
		GLOBAL $address;
		GLOBAL $shipping_fullname;
		GLOBAL $shipping_phone ;
		GLOBAL $shipping_address ;
			  
				
		//thêm khách hàng mới vào csdl
		 $max_guest_id = mysqli_fetch_row(mysqli_query($connect, "SELECT max(`id`) FROM `guest`"));	  
		 $guest_id=(++$max_guest_id[0]);    
		 insert_guest($guest_id,$fullname,$phone,$address,$email,$_customer_id);
		  
			  
		//thêm hóa đơn mới vào csdl
		
		$max_order_id = mysqli_fetch_row(mysqli_query($connect, "SELECT max(`id`) FROM `order`"));	  
		$order_id=(++$max_order_id[0]); 
		$total = get_total();
		$rs=insert_order($order_id,$fullname,$phone,$address,$email,$shipping_fullname,$shipping_address,$shipping_phone,$total,$guest_id);
		
		if($rs)
		  {
			inser_cart_detail($order_id);
		   unset($_SESSION['giohang']);  
		   header("Location: Complete.php");
		  }else{
			  echo "Lổi:".mysqli_error($connect);
			  header("Location: 404.php");
			  }
		}
	
	//hàm lấy tổng giá trong giỏ hàng
	function get_total()
		{
			GLOBAL $connect;
			$total=1;
			for($i = 0; $i < count($_SESSION['giohang']); $i++){
					   $product_id = $_SESSION['giohang'][$i]['id'];
					   $quantity = $_SESSION['giohang'][$i]['soluong'];
					   $product = mysqli_query($connect, "SELECT `price` FROM `products` WHERE `id`=".$product_id);
					   $row1 = mysqli_fetch_array($product);
					   $price = $row1['price'];
					   $total+=($price*$quantity);
			}
			return $total;
		}
		
	//hàmg thêm hóa đơn vào csdl
	function insert_order($_order_id,$_fullname,$_phone,$_address,$_email,$_shipping_fullname,$_shipping_address,$_shipping_phone,$_total,$_guest_id)
		{
			GLOBAL $connect;
		$query_insert_order = mysqli_query($connect, "INSERT INTO `order`(`id`,`fullname`,`phone`,`address`,`email`,`shipping_fullname`,`shipping_address`,`shipping_phone`,`total`,`guest_id`) 
										VALUES ($_order_id,'$_fullname','$_phone','$_address','$_email','$_shipping_fullname',',$_shipping_address','$_shipping_phone','$_total',$_guest_id)");
		
			return $query_insert_order;
		}
	
	//hàm thêm giỏ hàng vào csdl
	function inser_cart_detail($_order_id)
		{
			GLOBAL $connect;
			for($i = 0; $i < count($_SESSION['giohang']);$i++){
				   $product_id = $_SESSION['giohang'][$i]['id'];
				   $quantity = $_SESSION['giohang'][$i]['soluong'];
				   $product = mysqli_query($connect, "SELECT `price` FROM `products` WHERE `id`=".$product_id);
				   $row = mysqli_fetch_array($product);
				   $price = $row['price'];
				   mysqli_query($connect, "INSERT INTO `cart_detail`(`order_id`,`product_id`,`quantity`,`price`) 
											VALUES('$_order_id','$product_id','$quantity','$price')");
				}
		}
	
	//hàm thêm khách hàng mới vào csdl
	function insert_guest($_guest_id,$_fullname,$_phone,$_address,$_email,$_customer_id)
		{
				GLOBAL $connect;   
		$query_insert_guest = mysqli_query($connect, "INSERT INTO `guest`(`id`,`fullname`,`phone`,`address`,`email`,`customer_id`) 
												VALUES ($_guest_id,'$_fullname','$_phone','$_address','$_email','$_customer_id')");
		
		return $query_insert_guest;
		}
?>