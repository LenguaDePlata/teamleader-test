<?php

declare(strict_types=1);

namespace App\Tests\Mother\Discounts;

use App\Discounts\Domain\Model\Product\Product;

final class ProductMother
{
	public static function aSwitchProduct(): Product
	{
		return new Product(
			id: "B102",
			description: "Press button",
			category: 2,
			price: 4.99
		);
	}
}