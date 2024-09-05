<?php

namespace App\Discounts\Domain\Composite\Discount;

use App\Discounts\Domain\Model\Order\Order;

class DiscountComposite implements Discount
{
	public function apply(Order $order): void
	{}

	public function add(Discount $discount): void
	{}
}