<?php

declare(strict_types=1);

namespace App\Discounts\Infrastructure\Specification\DiscountCheck;

use App\Discounts\Domain\Specification\DiscountCheck\FiveProductsOfCategorySwitches as FiveProductsOfCategorySwitchesInterface;
use App\Discounts\Domain\Enum\Product\ProductCategory;
use App\Discounts\Domain\Model\Order\Order;

class FiveProductsOfCategorySwitches implements FiveProductsOfCategorySwitchesInterface
{
	public function isSatisfiedBy(Order $order): bool
	{
		foreach ($order->orderItems() as $orderItem) {
			/** @var OrderItem $orderItem */
			if ($orderItem->quantity()->isEqualToOrGreaterThan(5) && $orderItem->product()->category()->equalsTo(ProductCategory::Switches->id())) {
				return true;
			}
		}
		return false;
	}
}