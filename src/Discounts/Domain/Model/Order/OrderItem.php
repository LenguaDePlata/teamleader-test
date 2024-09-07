<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Model\Order;

use App\Discounts\Domain\Model\Product\Product;
use App\Discounts\Domain\ValueObject\Order\AppliedDiscount;
use App\Discounts\Domain\ValueObject\Order\Quantity;
use App\Discounts\Domain\ValueObject\Shared\Amount;

class OrderItem
{
	private Product $product;
	private Quantity $quantity;
	private Amount $unitPrice;
	private Amount $total;
	/** @var AppliedDiscount[] $discountsAppliedToItem */
	private array $discountsAppliedToItem = [];

	public function __construct(
		Product $product,
		int $quantity,
		float $unitPrice,
		float $total
	) {
		$this->product = $product;
		$this->quantity = new Quantity($quantity);
		$this->unitPrice = new Amount($unitPrice);
		$this->total = new Amount($total);
	}

	public function product(): Product
	{
		return $this->product;
	}

	public function quantity(): Quantity
	{
		return $this->quantity;
	}

	public function unitPrice(): Amount
	{
		return $this->unitPrice;
	}

	public function total(): Amount
	{
		return $this->total;
	}

	/** @return AppliedDiscount[] */
	public function discountsAppliedToItem(): array
	{
		return $this->discountsAppliedToItem;
	}

	public function addAppliedDiscount(string $discountName): void
	{
		$this->discountsAppliedToItem[] = new AppliedDiscount($discountName);
	}

	public function setTotal(float $total): void
	{
		$this->total = new Amount($total);
	}

	public function setUnitPrice(): void
	{
		$this->unitPrice = new Amount($unitPrice);
	}
}