<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Model\Order;

use App\Discounts\Domain\ValueObject\Customer\CustomerId;
use App\Discounts\Domain\ValueObject\Order\AppliedDiscounts;
use App\Discounts\Domain\ValueObject\Order\OrderId;
use App\Discounts\Domain\ValueObject\Shared\Amount;

class Order
{
	private OrderId $id;
	private CustomerId $customerId;
	/** @var OrderItem[] $orderItems */
	private array $orderLines;
	private Amount $total;
	private AppliedDiscounts $discountsAppliedToTotal;

	/**
		@param OrderItem[] $orderItems
	*/
	public function __construct(
		int $id,
		int $customerId,
		array $orderItems,
		float $total
	) {
		$this->id = new OrderId($id);
		$this->customerId = new CustomerId($customerId);
		$this->orderItems = $orderItems;
		$this->total = new Amount($total);
	}

	public function applyDiscounts(): void
	{}

	public function total(): Amount
	{
		return $this->total;
	}

	/**
		@return OrderItem[]
	*/
	public function orderItems(): array
	{
		return $this->orderItems;
	}

	public function discountsAppliedToTotal(): AppliedDiscounts|null
	{
		return isset($this->discountsAppliedToTotal) ? $this->discountsAppliedToTotal : null;
	}
}