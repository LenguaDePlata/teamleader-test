<?php

declare(strict_types=1);

namespace App\Discounts\Infrastructure\Specification\DiscountCheck;

use App\Discounts\Domain\Specification\DiscountCheck\TwoOrMoreProductsOfCategoryTools as TwoOrMoreProductsOfCategoryToolsInterface;
use App\Discounts\Domain\Enum\Product\ProductCategory;
use App\Discounts\Domain\Model\Order\Order;

class TwoOrMoreProductsOfCategoryTools implements TwoOrMoreProductsOfCategoryToolsInterface
{
	public function isSatisfiedBy(Order $order): bool
	{
		$totalToolProducts = 0;
		foreach ($order->orderItems() as $orderItem) {
			/** @var OrderItem $orderItem */
			if ($orderItem->product()->category()->equalsTo(ProductCategory::Tools->id())) {
				$totalToolProducts += $orderItem->quantity()->__toInt();
				if ($totalToolProducts >= 2) {
					return true;
				}
			}
		}
		return false;
	}
}