<?php

declare(strict_types=1);

namespace App\Tests\Mother\Discounts;

use App\Discounts\Domain\Model\Order\Order;

final class OrderMother
{
	public static function aValidOrderWithOneItemAndNoDiscounts(): Order
	{
		return new Order(
			id: 1,
			customerId: 1,
			orderItems: [
				OrderItemMother::aTenSwitchProductItem()
			],
			total: 49.90
		);
	}

	public static function aValidOrderWithMultipleItemsAndDiscounts(): Order
	{
		$order = new Order(
			id: 3,
			customerId: 3,
			orderItems: [
				OrderItemMother::aTwoToolProductItemWithDiscounts(),
				OrderItemMother::aOneToolProductItem(),
			],
			total: 69.00
		);
		$order->addAppliedDiscount('discount-1');
		$order->addAppliedDiscount('discount-2');
		$order->addAppliedDiscount('discount-3');
		return $order;
	}

	public static function aValidOrderWithTotalOver1000AndNoDiscounts(): Order
	{
		return new Order(
			id: 4,
			customerId: 4,
			orderItems: [
				OrderItemMother::aThousandSwitchProductItem()
			],
			total: 4990.00
		);
	}

	public static function aValidOrderWithMultipleToolItemsAndNoDiscounts(): Order
	{
		return new Order(
			id: 3,
			customerId: 3,
			orderItems: [
				OrderItemMother::aTwoToolProductItem(),
				OrderItemMother::aOneToolProductItem(),
			],
			total: 69.00
		);
	}

	public static function aValidOrderWithMultipleLessThanFiveSwitchItems(): Order
	{
		return new Order(
			id: 5,
			customerId: 5,
			orderItems: [
				OrderItemMother::aFourSwitchProductItem(),
				OrderItemMother::aOneSwitchProductItem(),
			],
			total: 24.95
		);
	}
}