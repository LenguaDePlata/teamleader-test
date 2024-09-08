<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Composite\Discount;

use App\Discounts\Domain\Enum\Product\ProductCategory;
use App\Discounts\Domain\Model\Order\Order;
use App\Discounts\Domain\Model\Order\OrderItem;

class ForEveryFiveProductsOfCategorySwitchesGetOneFree implements Discount
{
	private const DISCOUNT_NAME = 'for-every-five-products-of-category-switches-get-one-free';

	public function apply(Order $order): void
	{
		$freeProductsOrderItems = [];
		foreach ($order->orderItems() as $orderItem) {
			/** @var OrderItem $orderItem */
			if ($orderItem->quantity()->isEqualToOrGreaterThan(5) && $orderItem->product()->category()->equalsTo(ProductCategory::Switches->id())) {
				$howManyFreeProducts = $orderItem->quantity()->__toInt() / 5;
				$freeOrderItem = new OrderItem(
					product: $orderItem->product(),
					quantity: $howManyFreeProducts,
					unitPrice: 0.0,
					total: 0.0
				);
				$freeOrderItem->addAppliedDiscount(self::DISCOUNT_NAME);
				$freeProductsOrderItems[] = $freeOrderItem;
			}
		}
		$order->addOrderItems($freeProductsOrderItems);
	}
}