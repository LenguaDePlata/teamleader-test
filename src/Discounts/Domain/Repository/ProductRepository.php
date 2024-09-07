<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Repository;

use App\Discounts\Domain\Model\Product\Product;
use App\Discounts\Domain\ValueObject\Product\ProductId;

interface ProductRepository
{
	public function findById(ProductId $id): ?Product;
}