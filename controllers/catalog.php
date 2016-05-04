<?php
	/**
	 * Created by PhpStorm.
	 * User: art
	 * Date: 12/6/2015
	 * Time: 02:05 PM
	 */
	class Application_Controllers_Catalog extends Lib_BaseController
	{
		function index()
		{
			if($_REQUEST['in-cart-product-id'])
			{
				$cart=new Application_Models_Cart;
				$cart->addToCart($_REQUEST['in-cart-product-id']);
				Lib_SmalCart::getInstance()->setCartData();
				header('Location: /catalog');
				exit;
			}

			$model=new Application_Models_Catalog;
			$Items = $model->getList();
			$this->Items=$Items;
		}
	}