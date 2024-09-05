<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Model\Order;

use App\Discounts\Domain\ValueObject\Order\AppliedDiscounts;
use App\Discounts\Domain\ValueObject\Order\Quantity;
use App\Discounts\Domain\ValueObject\Product\ProductId;
use App\Discounts\Domain\ValueObject\Shared\Amount;

class OrderItem
{
	private ProductId $productId;
	private Quantity $quantity;
	private Amount $unitPrice;
	private Amount $total;
	private AppliedDiscounts $discountsAppliedToItem;

	public function __construct(
		string $productId,
		int $quantity,
		float $unitPrice,
		float $total
	) {
		$this->productId = new ProductId($productId);
		$this->quantity = new Quantity($quantity);
		$this->unitPrice = new Amount($total);
		$this->total = new Amount($total);
	}

	public function productId(): ProductId
	{
		return $this->productId;
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

	public function discountsAppliedToItem(): AppliedDiscounts|null
	{
		return isset($this->discountsAppliedToItem) ? $this->discountsAppliedToItem : null;
	}
}