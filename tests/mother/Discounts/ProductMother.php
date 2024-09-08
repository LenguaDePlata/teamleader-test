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

	public static function aCheapToolProduct(): Product
	{
		return new Product(
			id: "A101",
			description: "Screwdriver",
			category: 1,
			price: 9.75
		);
	}

	public static function anExpensiveToolProduct(): Product
	{
		return new Product(
			id: "A102",
			description: "Electric screwdriver",
			category: 1,
			price: 49.50
		);
	}

	public static function a1000PriceProduct(): Product
	{
		return new Product(
			id: "X101",
			description: "Nuclear screwdriver",
			category: 1,
			price: 1000.00
		);
	}
}