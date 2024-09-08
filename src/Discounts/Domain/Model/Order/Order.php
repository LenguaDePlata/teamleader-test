<?php

declare(strict_types=1);

namespace App\Discounts\Domain\Model\Order;

use App\Discounts\Domain\Composite\Discount\Discount;
use App\Discounts\Domain\Composite\Discount\DiscountComposite;
use App\Discounts\Domain\Composite\Discount\ForEveryFiveProductsOfCategorySwitchesGetOneFree;
use App\Discounts\Domain\Composite\Discount\TenPercentOffWholeOrder;
use App\Discounts\Domain\Composite\Discount\TwentyPercentOffCheapestProductOfCategoryTools;
use App\Discounts\Domain\Specification\DiscountCheck\DiscountCheck;
use App\Discounts\Domain\Specification\DiscountCheck\FiveProductsOfCategorySwitches;
use App\Discounts\Domain\Specification\DiscountCheck\TwoOrMoreProductsOfCategoryTools;
use App\Discounts\Domain\Specification\DiscountCheck\TotalOverOneThousand;
use App\Discounts\Domain\ValueObject\Customer\CustomerId;
use App\Discounts\Domain\ValueObject\Order\AppliedDiscount;
use App\Discounts\Domain\ValueObject\Order\OrderId;
use App\Discounts\Domain\ValueObject\Shared\Amount;

class Order
{
	private OrderId $id;
	private CustomerId $customerId;
	/** @var OrderItem[] $orderItems */
	private array $orderItems;
	private Amount $total;
	/** @var AppliedDiscount[] $discountsAppliedToTotal */
	private array $discountsAppliedToTotal = [];

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


	/**
		@throws UndefinedDiscountCheckException
	*/
	public function applyDiscounts(DiscountCheck ...$discountChecks): void
	{
		$discounts = $this->getDiscountsToApply(...$discountChecks);
		$discounts->apply($this);
	}


	/**
		@throws UndefinedDiscountCheckException
	*/
	private function getDiscountsToApply(DiscountCheck ...$discountChecks): DiscountComposite
	{
		$discounts = new DiscountComposite();
		foreach ($discountChecks as $discountCheck) {
			if ($discountCheck->isSatisfiedBy($this)) {
				$discounts->add($this->getDiscountInstanceFromCheck($discountCheck));
			}
		}
		return $discounts;
	}

	/**
		@throws UndefinedDiscountCheckException
	*/
	private function getDiscountInstanceFromCheck(DiscountCheck $discountCheck): Discount
	{
		if ($discountCheck instanceof FiveProductsOfCategorySwitches) {
			return new ForEveryFiveProductsOfCategorySwitchesGetOneFree();
		} else if ($discountCheck instanceof TwoOrMoreProductsOfCategoryTools) {
			return new TwentyPercentOffCheapestProductOfCategoryTools();
		} else if ($discountCheck instanceof TotalOverOneThousand) {
			return new TenPercentOffWholeOrder();
		} else {
			throw new UndefinedDiscountCheckException(get_class($discountCheck));
		}
	}

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

	/**
		@return AppliedDiscount[]
	*/
	public function discountsAppliedToTotal(): array
	{
		return $this->discountsAppliedToTotal;
	}

	/**
		@param OrderItem[] $orderItems
	*/
	public function addOrderItems(array $orderItems): void
	{
		foreach ($orderItems as $orderItem) {
			$this->orderItems[] = $orderItem;
		}
	}

	public function setOrderItem(OrderItem $orderItem, int $key): void
	{
		$this->orderItems[$key] = $orderItem;
	}

	public function addAppliedDiscount(string $discountName): void
	{
		$this->discountsAppliedToTotal[] = new AppliedDiscount($discountName);
	}

	public function setTotal(float $total): void
	{
		$this->total = new Amount($total);
	}
}