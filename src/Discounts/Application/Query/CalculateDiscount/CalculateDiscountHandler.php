<?php

declare(strict_types=1);

namespace App\Discounts\Application\Query\CalculateDiscount;

use App\Discounts\Application\Assembler\CalculateDiscountResponseAssembler;
use App\Discounts\Domain\Builder\OrderBuilder;

class CalculateDiscountHandler
{
	public function __construct(
		private OrderBuilder $orderBuilder,
		private CalculateDiscountResponseAssembler $calculateDiscountResponseAssembler
	){}

	public function handle(CalculateDiscountQuery $query): CalculateDiscountResponse
	{
		$order = $this->orderBuilder->build(
			$query->getId(),
			$query->getCustomerId(),
			$query->getOrderItems(),
			$query->getTotal()
		);

		// Redirect to domain function to apply discounts (composite for each discount, specification to check which to add to the composite)
		$order->applyDiscounts();
		
		return $this->calculateDiscountResponseAssembler->toDTO($order, $query);
	}
}