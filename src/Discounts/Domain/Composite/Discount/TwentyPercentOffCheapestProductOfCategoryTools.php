<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Composite\Discount;

use App\Discounts\Domain\Model\Order\Order;

class TwentyPercentOffCheapestProductOfCategoryTools implements Discount
{
	public function apply(Order $order): void
	{
		$cheapestProductPrice = 0;
		$cheapestOrderItemKey = null;
		$cheapestOrderItem = null;
		foreach ($order->orderItems() as $key => $orderItem) {
			if (
				$orderItem->product()->category()->equalsTo(ProductCategory::Tools->id())
				&& (
					$orderItem->product()->price()->isLowerThan($cheapestProductPrice)
					|| $cheapestProductPrice === 0
				)
			) {
				$cheapestProductPrice = (float)$orderItem->product()->price();
				$cheapestOrderItemKey = $key;
				$cheapestOrderItem = $orderItem;
			}
		}

		$cheapestTotal = (float)$cheapestOrderItem->total();
		$cheapestUnitPrice = (float)$cheapestOrderItem->unitPrice();

		$discountedTotal = round($cheapestTotal*0.2, 2);
		$discountedUnitPrice = round($cheapestUnitPrice*0.2, 2);
		$cheapestOrderItem->setTotal($discountedTotal);
		$cheapestOrderItem->setUnitPrice($discountedUnitPrice);

		$order->setOrderItem($cheapestOrderItem, $cheapestOrderItemKey);
	}
}