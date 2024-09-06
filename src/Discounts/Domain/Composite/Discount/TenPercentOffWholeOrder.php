<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Composite\Discount;

use App\Discounts\Domain\Model\Order\Order;

class TenPercentOffWholeOrder implements Discount
{
	private const DISCOUNT_NAME = 'ten-percent-off-whole-order';

	public function apply(Order $order): void
	{
		$orderTotal = (float)$order->total();
		$discountedTotal = round($orderTotal*0.9, 2);
		$order->setTotal($discountedTotal);
		$order->addAppliedDiscount(self::DISCOUNT_NAME);
	}
}