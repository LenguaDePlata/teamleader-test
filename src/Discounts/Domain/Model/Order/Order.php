<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Model\Order;

class Order
{
	public function __construct(
		int $id,
		int $customerId,
		array $orderLines,
		float $total
	) {

	}
	
	public function applyDiscounts(): void
	{}
}