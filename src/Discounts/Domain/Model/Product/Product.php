<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Model\Product;

use App\Discounts\Domain\ValueObject\Product\Category;

class Product
{
	// TODO: properly define the constructor and all the properties
	private Category $category;

	public function getCategory(): Category
	{
		return $this->category;
	}
}
