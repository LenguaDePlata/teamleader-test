<?php

declare(strict_types=1);

namespace App\Discounts\Domain\ValueObject\Product;

use App\Discounts\Domain\ValueObject\Shared\Amount;

final class Price extends Amount
{
	public function isLowerThan(float $price): bool
	{
		return $this->value < $price;
	}
}