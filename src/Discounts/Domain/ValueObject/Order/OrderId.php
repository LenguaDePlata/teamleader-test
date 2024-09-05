<?php

declare(strict_types=1);

namespace App\Discounts\Domain\ValueObject\Order;

final class OrderId
{
	public function __construct(
		private int $value
	){}
}