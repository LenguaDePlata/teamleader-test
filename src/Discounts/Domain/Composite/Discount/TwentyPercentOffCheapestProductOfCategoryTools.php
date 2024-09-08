<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Composite\Discount;

use App\Discounts\Domain\Enum\Product\ProductCategory;
use App\Discounts\Domain\Model\Order\Order;
use App\Discounts\Domain\Model\Order\OrderItem;

class TwentyPercentOffCheapestProductOfCategoryTools implements Discount
{
	private const DISCOUNT_NAME = 'twenty-percent-off-cheapest-tool-product';

	public function apply(Order $order): void
	{
		$cheapestProductPrice = 0;
		$cheapestOrderItemKey = null;
		$cheapestOrderItem = null;
		foreach ($order->orderItems() as $key => $orderItem) {
			/** @var OrderItem $orderItem */
			if (
				$orderItem->product()->category()->equalsTo(ProductCategory::Tools->id())
				&& (
					$orderItem->product()->price()->isLowerThan($cheapestProductPrice)
					|| $cheapestProductPrice === 0
				)
			) {
				$cheapestProductPrice = $orderItem->product()->price()->__toFloat();
				$cheapestOrderItemKey = $key;
				$cheapestOrderItem = $orderItem;
			}
		}

		$cheapestTotal = $cheapestOrderItem->total()->__toFloat();
		$cheapestUnitPrice = $cheapestOrderItem->unitPrice()->__toFloat();

		$discountedTotal = round($cheapestTotal*0.8, 2);
		$discountedUnitPrice = round($cheapestUnitPrice*0.8, 2);
		$cheapestOrderItem->setTotal($discountedTotal);
		$cheapestOrderItem->setUnitPrice($discountedUnitPrice);
		$cheapestOrderItem->addAppliedDiscount(self::DISCOUNT_NAME);

		$order->setOrderItem($cheapestOrderItem, $cheapestOrderItemKey);
		$order->setTotal(
			round($order->total()->__toFloat() - $cheapestTotal + $discountedTotal, 2)
		);
	}
}