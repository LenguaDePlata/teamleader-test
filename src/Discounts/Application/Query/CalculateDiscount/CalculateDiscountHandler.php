<?php

declare(strict_types=1);

namespace App\Discounts\Application\Query\CalculateDiscount;

use App\Discounts\Application\Assembler\CalculateDiscountResponseAssembler;
use App\Discounts\Domain\Builder\OrderBuilder;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

class CalculateDiscountHandler
{
	public function __construct(
		private OrderBuilder $orderBuilder,
		private CalculateDiscountResponseAssembler $calculateDiscountResponseAssembler,
		/** @var DiscountCheck[] $discountChecks */
		#[AutowireIterator('app.discounts.discount_check')]
		private iterable $discountChecks
	){}

	
	/**
		@throws UnexpectedDiscountErrorException
	*/
	public function handle(CalculateDiscountQuery $query): CalculateDiscountResponse
	{
		try {
			$order = $this->orderBuilder->build(
				$query->getId(),
				$query->getCustomerId(),
				$query->getOrderItems(),
				$query->getTotal()
			);

			$order->applyDiscounts(...$discountChecks);
			
			return $this->calculateDiscountResponseAssembler->toDTO($order, $query);
		} catch (UndefinedDiscountCheckException $e) {
			throw new UnexpectedDiscountErrorException($e);
		}
	}
}