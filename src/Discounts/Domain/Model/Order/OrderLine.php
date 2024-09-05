<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Model\Order;

class OrderLine
{
	public function __construct(
		string $productId,
		int $quantity,
		float $unitPrice,
		float $total
	) {}
}