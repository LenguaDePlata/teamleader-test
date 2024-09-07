<?php

declare(strict_types=1);

namespace App\Tests\Mother\Discounts;

use App\Discounts\Domain\Model\Order\OrderItem;

final class OrderItemMother
{
	public static function aTenSwitchProductItem(): OrderItem
	{
		return new OrderItem(
			product: ProductMother::aSwitchProduct(),
			quantity: 10,
			unitPrice: 4.99,
			total: 49.90
		);
	}

	public static function aTwoToolProductItemWithDiscounts(): OrderItem
	{
		$item = new OrderItem(
			product: ProductMother::aCheapToolProduct(),
			quantity: 2,
			unitPrice: 9.75,
			total: 19.50
		);
		$item->addAppliedDiscount('discount-1');
		$item->addAppliedDiscount('discount-2');
		$item->addAppliedDiscount('discount-3');
		return $item;
	}

	public static function aOneToolProductItem(): OrderItem
	{
		return new OrderItem(
			product: ProductMother::anExpensiveToolProduct(),
			quantity: 1,
			unitPrice: 49.50,
			total: 49.50
		);
	}
}