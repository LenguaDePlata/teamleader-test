<?php

declare(strict_types=1);

namespace App\Tests\Unit\Discounts\Domain\Composite\Discount;

use App\Discounts\Domain\Composite\Discount\TenPercentOffWholeOrder;
use App\Discounts\Domain\Model\Order\Order;
use App\Tests\Mother\Discounts\OrderMother;
use PHPUnit\Framework\TestCase;

final class TenPercentOffWholeOrderTest extends TestCase
{
	private const THIS_DISCOUNT_NAME = 'ten-percent-off-whole-order';

	private TenPercentOffWholeOrder $discount;

	protected function setUp(): void
	{
		$this->discount = new TenPercentOffWholeOrder();
	}

	public function testItAppliesTheDiscount(): void
	{
		// Arrange
		$order = OrderMother::aValidOrderWithTotalOver1000AndNoDiscounts();

		// Act
		$this->discount->apply($order);

		// Assert
		$originalOrder = OrderMother::aValidOrderWithTotalOver1000AndNoDiscounts();
		$this->assertCount(count($originalOrder->orderItems()), $order->orderItems());
		$this->assertEquals(
			round($originalOrder->total()->__toFloat() * 0.9, 2),
			$order->total()->__toFloat()
		);
		$this->assertEquals(
			self::THIS_DISCOUNT_NAME,
			$order->discountsAppliedToTotal()[0]->__toString()
		);
	}
}
