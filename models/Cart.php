<?php

	namespace app\models;

	use Yii;

	class Cart
	{

		function addToCart()
		{
			session_start();
			// id ??????
			$_SESSION['product_id'] = $_POST['product_id'];
			$_SESSION['color_id'] = $_POST['color_id'];
			$_SESSION['size_id'] = $_POST['size_id'];
			// ???-?? ??????
			$_SESSION['count'] = 1;
		}




		function delFromCart($id, $color, $size, $count=1){}

		function clearCart(){}
	}
