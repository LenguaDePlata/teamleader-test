<?php

declare(strict_types=1);

namespace App\Discounts\Infrastructure\Specification\DiscountCheck;

use App\Discounts\Domain\Specification\DiscountCheck\TotalOverOneThousand as TotalOverOneThousandInterface;
use App\Discounts\Domain\Model\Order\Order;

class TotalOverOneThousand implements TotalOverOneThousandInterface
{
	public function isSatisfiedBy(Order $order): bool
	{
		return $order->total()->__toFloat() > 1000.00;
	}
}