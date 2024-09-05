<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Enum\Product;

enum ProductCategory
{
	case Tools;
	case Switches;

	public function id(): int
	{
		return match($this) {
			ProductCategory::Tools => 1,
			ProductCategory::Switches => 2
		};
	}
}