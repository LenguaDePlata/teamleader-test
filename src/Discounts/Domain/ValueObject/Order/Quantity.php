<?php

declare(strict_types=1);

namespace App\Discounts\Domain\ValueObject\Order;

final class Quantity
{
	public function __construct(
		private int $value
	){}

	public function __toInt(): int
	{
		return $this->value;
	}

	public function isEqualToOrGreaterThan(int $quantity): boolean
	{
		return $this->value >= $quantity;
	}
}