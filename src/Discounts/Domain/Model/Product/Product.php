<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Model\Product;

use App\Discounts\Domain\ValueObject\Product\Category;
use App\Discounts\Domain\ValueObject\Product\Description;
use App\Discounts\Domain\ValueObject\Product\ProductId;
use App\Discounts\Domain\ValueObject\Product\Price;

class Product
{
	private int $_id;
	private ProductId $id;
	private Description $description;
	private Category $category;
	private Price $price;

	public function __construct(
		string $id,
		string $description,
		int $category,
		float $price
	){
		$this->id = new ProductId($id);
		$this->description = new Description($description);
		$this->category = new Category($category);
		$this->price = new Price($price);
	}

	public function id(): ProductId
	{
		return $this->id;
	}

	public function category(): Category
	{
		return $this->category;
	}

	public function price(): Price
	{
		return $this->price;
	}
}
