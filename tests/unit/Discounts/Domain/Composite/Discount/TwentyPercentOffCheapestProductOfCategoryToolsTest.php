<?php

declare(strict_types=1);

namespace App\Tests\Unit\Discounts\Domain\Composite\Discount;

use App\Discounts\Domain\Composite\Discount\TwentyPercentOffCheapestProductOfCategoryTools;
use App\Discounts\Domain\Enum\Product\ProductCategory;
use App\Discounts\Domain\Model\Order\Order;
use App\Discounts\Domain\Model\Order\OrderItem;
use App\Tests\Mother\Discounts\OrderMother;
use App\Tests\Mother\Discounts\OrderItemMother;
use PHPUnit\Framework\TestCase;

final class TwentyPercentOffCheapestProductOfCategoryToolsTest extends TestCase
{
	private const THIS_DISCOUNT_NAME = 'twenty-percent-off-cheapest-tool-product';

	private TwentyPercentOffCheapestProductOfCategoryTools $discount;

	protected function setUp(): void
	{
		$this->discount = new TwentyPercentOffCheapestProductOfCategoryTools();
	}

	public function testItAppliesTheDiscountToOrderItem(): void
	{
		// Arrange
		$order = OrderMother::aValidOrderWithMultipleToolItemsAndNoDiscounts();
		$cheapestOrderItem = OrderItemMother::aTwoToolProductItem();

		// Act
		$this->discount->apply($order);

		// Assert
		$originalOrder = OrderMother::aValidOrderWithMultipleToolItemsAndNoDiscounts();

		$cheapestTotal = $cheapestOrderItem->total()->__toFloat();
		$discountedTotal = round($cheapestTotal*0.8, 2);
		$this->assertEquals(
			round($originalOrder->total()->__toFloat() - $cheapestTotal + $discountedTotal, 2),
			$order->total()->__toFloat()
		);

		$this->assertTrue(
			$this->thenOrderContainsTheCheapestToolItemWithThisDiscount($order, $cheapestOrderItem)
		);
	}

	public function testItAppliesNothingToOrderIfThereAreNoTools()
	{

	}

	private function thenOrderContainsTheCheapestToolItemWithThisDiscount(Order $order, OrderItem $cheapestItem): bool
	{
		foreach ($order->orderItems() as $orderItem) {
			if (
				$orderItem->product()->category()->equalsTo(ProductCategory::Tools->id())
				&& $orderItem->product()->id()->__toString() === $cheapestItem->product()->id()->__toString()
				&& count($orderItem->discountsAppliedToItem()) == 1
				&& $orderItem->discountsAppliedToItem()[0]->__toString() === self::THIS_DISCOUNT_NAME
				&& $cheapestItem->quantity()->__toInt() === $orderItem->quantity()->__toInt()
				&& round($cheapestItem->total()->__toFloat()*0.8, 2) === $orderItem->total()->__toFloat()
				&& round($cheapestItem->unitPrice()->__toFloat()*0.8, 2) === $orderItem->unitPrice()->__toFloat()
			) {
				return true;
			}
		}
		return false;
	}
}