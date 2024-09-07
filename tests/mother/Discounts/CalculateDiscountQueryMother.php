<?php

declare(strict_types=1);

namespace App\Tests\Mother\Discounts;

use App\Discounts\Application\DTO\OrderItemDTO;
use App\Discounts\Application\Query\CalculateDiscount\CalculateDiscountQuery;

final class CalculateDiscountQueryMother
{
	public static function aValidQueryWithOneItem(): CalculateDiscountQuery
	{
		return new CalculateDiscountQuery(
			id: 1,
			customerId: 1,
			orderItems: [
				new OrderItemDTO(
					productId: "B102",
					quantity: 10,
					unitPrice: 4.99,
					total: 49.90
				)
			],
			total: 49.90
		);
	}

	public static function aValidQueryWithMultipleItems(): CalculateDiscountQuery
	{
		return new CalculateDiscountQuery(
			id: 3,
			customerId: 3,
			orderItems: [
				new OrderItemDTO(
					productId: "A101",
					quantity: 2,
					unitPrice: 9.75,
					total: 19.50
				),
				new OrderItemDTO(
					productId: "A102",
					quantity: 1,
					unitPrice: 49.50,
					total: 49.50
				)
			],
			total: 69.00
		);
	}
}