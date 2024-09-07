<?php

declare(strict_types=1);

namespace App\Tests\Mother\Discounts;

use App\Discounts\Application\DTO\OrderItemDTO;
use App\Discounts\Application\Query\CalculateDiscount\CalculateDiscountQuery;

final class CalculateDiscountQueryMother
{
	public static function aValidCalculateDiscountQuery(): CalculateDiscountQuery
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
}