<?php

declare(strict_types=1);

namespace App\Discounts\Domain\ValueObject\Product;

final class Description
{
	public function __construct(
		private string $value
	){}
}