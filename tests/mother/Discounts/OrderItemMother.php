<?php

declare(strict_types=1);

namespace App\Tests\Mother\Discounts;

use App\Discounts\Domain\Model\Order\OrderItem;

final class OrderItemMother
{
	public static function aTenSwitchProductItem(): OrderItem
	{
		return self::anOrderItemWithThisManySwitchProducts(10);
	}

	public static function aFourSwitchProductItem(): OrderItem
	{
		return self::anOrderItemWithThisManySwitchProducts(4);
	}

	public static function aOneSwitchProductItem(): OrderItem
	{
		return self::anOrderItemWithThisManySwitchProducts(1);
	}

	private static function anOrderItemWithThisManySwitchProducts(int $quantity): OrderItem
	{
		return new OrderItem(
			product: ProductMother::aSwitchProduct(),
			quantity: $quantity,
			unitPrice: 4.99,
			total: round(4.99 * (float)$quantity, 2)
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

	public static function aTwoToolProductItem(): OrderItem
	{
		return new OrderItem(
			product: ProductMother::aCheapToolProduct(),
			quantity: 2,
			unitPrice: 9.75,
			total: 19.50
		);
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

	public static function aThousandSwitchProductItem(): OrderItem
	{
		return new OrderItem(
			product: ProductMother::aSwitchProduct(),
			quantity: 1000,
			unitPrice: 4.99,
			total: 4990.00
		);
	}

	public static function a1000PriceProductItem(): OrderItem
	{
		return new OrderItem(
			product: ProductMother::a1000PriceProduct(),
			quantity: 1,
			unitPrice: 1000.00,
			total: 1000.00
		);
	}
}