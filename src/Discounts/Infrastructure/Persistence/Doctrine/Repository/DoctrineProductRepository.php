<?php

declare(strict_types=1);

namespace App\Discounts\Infrastructure\Persistence\Doctrine\Repository;

use App\Discounts\Domain\Repository\ProductRepository;
use App\Discounts\Domain\Model\Product\Product;
use App\Discounts\Domain\ValueObject\Product\ProductId;
use App\Shared\Infrastructure\Persistence\Doctrine\Repository\AbstractDoctrineRepository as AbstractRepository;

class DoctrineProductRepository extends AbstractRepository implements ProductRepository
{
	public function findById(ProductId $id): ?Product
	{
		return $this->repository->findOneBy([
			'productId.value' => (string)$id
		]);
	}

	public function className(): string
	{
		return Product::class;
	}
}