<?php

declare(strict_types=1);

namespace App\Tests\Mother\Discounts;

use App\Discounts\Domain\Model\Order\Order;

final class OrderMother
{
	public static function aValidOrder(): Order
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
}