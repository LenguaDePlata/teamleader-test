<?php

declare(strict_types=1);

namespace App\Discounts\Domain\ValueObject\Order;

final class AppliedDiscount
{
	public function __construct(
		private string $value
	){}

	public function __toString(): string
	{
		return $this->value;
	}
}