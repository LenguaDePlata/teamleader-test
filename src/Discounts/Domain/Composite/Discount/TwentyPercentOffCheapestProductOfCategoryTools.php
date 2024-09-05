<?php

namespace App\Discounts\Domain\Composite\Discount;

use App\Discounts\Domain\Model\Order\Order;

class TwentyPercentOffCheapestProductOfCategoryTools implements Discount
{
	public function apply(Order $order): void
	{}
}