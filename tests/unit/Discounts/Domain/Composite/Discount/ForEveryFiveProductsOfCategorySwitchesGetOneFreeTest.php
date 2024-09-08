<?php

declare(strict_types=1);

namespace App\Tests\Unit\Discounts\Domain\Composite\Discount;

use App\Discounts\Domain\Composite\Discount\ForEveryFiveProductsOfCategorySwitchesGetOneFree;
use App\Discounts\Domain\Enum\Product\ProductCategory;
use App\Discounts\Domain\Model\Order\Order;
use App\Tests\Mother\Discounts\OrderMother;
use PHPUnit\Framework\TestCase;

final class ForEveryFiveProductsOfCategorySwitchesGetOneFreeTest extends TestCase
{
	private const THIS_DISCOUNT_NAME = 'for-every-five-products-of-category-switches-get-one-free';

	private ForEveryFiveProductsOfCategorySwitchesGetOneFree $discount;

	protected function setUp(): void
	{
		$this->discount = new ForEveryFiveProductsOfCategorySwitchesGetOneFree();
	}

	public function testItAppliesTheDiscountAndAddsNewItemWithFreeProducts(): void
	{
		// Arrange
		$order = OrderMother::aValidOrderWithOneItemAndNoDiscounts();

		// Act
		$this->discount->apply($order);

		// Assert
		$originalOrder = OrderMother::aValidOrderWithOneItemAndNoDiscounts();
		$this->assertEquals($originalOrder->total()->__toFloat(), $order->total()->__toFloat());
		$this->assertGreaterThan(count($originalOrder->orderItems()), count($order->orderItems()));
		$this->assertTrue(
			$this->thenOrderContainsAFreeItemWithThisDiscount($order)
		);
	}

	public function testItAddsNothingToTheOrderIfThereAreNoSwitches(): void
	{
		// Arrange
		$order = OrderMother::aValidOrderWithMultipleItemsAndDiscounts();

		// Act
		$this->discount->apply($order);

		// Assert
		$originalOrder = OrderMother::aValidOrderWithMultipleItemsAndDiscounts();
		$this->assertEquals($originalOrder->total()->__toFloat(), $order->total()->__toFloat());
		$this->assertCount(count($originalOrder->orderItems()), $order->orderItems());
		$this->assertTrue(
			$this->thenDoesNotContainAnyFreeSwitchItem($order)
		);
	}

	private function thenOrderContainsAFreeItemWithThisDiscount(Order $order): bool
	{
		foreach($order->orderItems() as $orderItem) {
			if (
				$orderItem->product()->category()->equalsTo(ProductCategory::Switches->id())
				&& $orderItem->unitPrice()->__toFloat() === 0.0
				&& $orderItem->total()->__toFloat() === 0.0
				&& $orderItem->quantity()->__toInt() === 2
				&& count($orderItem->discountsAppliedToItem()) == 1
				&& $orderItem->discountsAppliedToItem()[0]->__toString() === self::THIS_DISCOUNT_NAME
			) {
				return true;
			}
		}
		return false;
	}

	private function thenDoesNotContainAnyFreeSwitchItem(Order $order): bool
	{
		foreach($order->orderItems() as $orderItem) {
			if (
				$orderItem->product()->category()->equalsTo(ProductCategory::Switches->id())
				&& $orderItem->unitPrice()->__toFloat() === 0.0
				&& $orderItem->total()->__toFloat() === 0.0
				&& count($orderItem->discountsAppliedToItem()) == 1
				&& $orderItem->discountsAppliedToItem()[0]->__toString() === self::THIS_DISCOUNT_NAME
			) {
				return false;
			}
		}
		return true;
	}
}