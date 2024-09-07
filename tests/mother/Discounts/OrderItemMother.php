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
}