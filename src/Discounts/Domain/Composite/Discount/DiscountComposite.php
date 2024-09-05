<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Composite\Discount;

use App\Discounts\Domain\Model\Order\Order;

class DiscountComposite implements Discount
{
	private array $discounts = [];

	public function apply(Order $order): void
	{
		foreach ($this->discounts as $discount) {
			$discount->apply($order);
		}
	}

	public function add(Discount $discount): void
	{
		$this->discounts[] = $discount;
	}
}