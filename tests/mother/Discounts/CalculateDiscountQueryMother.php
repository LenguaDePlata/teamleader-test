<?php

declare(strict_types=1);

namespace App\Tests\Mother\Discounts;

use App\Discounts\Application\Query\CalculateDiscount\CalculateDiscountQuery;

final class CalculateDiscountQueryMother
{
	public static function aValidQueryWithOneItem(): CalculateDiscountQuery
	{
		return new CalculateDiscountQuery(
			id: 1,
			customerId: 1,
			orderItems: [
				OrderItemDTOMother::aTenSwitchProductItemDTO()
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
				OrderItemDTOMother::aTwoToolProductItemDTO(),
				OrderItemDTOMother::aOneToolProductItemDTO()
			],
			total: 69.00
		);
	}
}