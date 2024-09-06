<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Repository;

interface ProductRepository
{
	public function findById(ProductId $id): ?Product;
}