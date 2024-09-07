<?php

declare(strict_types=1);

namespace App\Tests\Unit\Discounts\Application\Assembler;

use App\Discounts\Application\Query\CalculateDiscount\CalculateDiscountQuery;
use App\Discounts\Application\Query\CalculateDiscount\CalculateDiscountResponse;
use App\Discounts\Application\Assembler\CalculateDiscountResponseAssembler;
use App\Discounts\Domain\Model\Order\Order;
use App\Tests\Mother\Discounts\OrderMother;
use App\Tests\Mother\Discounts\CalculateDiscountQueryMother;
use PHPUnit\Framework\TestCase;

final class CalculateDiscountResponseAssemblerTest extends TestCase
{
	private CalculateDiscountResponseAssembler $assembler;

	protected function setUp(): void
	{
		$this->assembler = new CalculateDiscountResponseAssembler();
		parent::setUp();
	}

	public function testItCreatesAValidResponseWithOneItemAndNoDiscounts(): void
	{
		//Arrange
		$order = OrderMother::aValidOrderWithOneItemAndNoDiscounts();
		$query = CalculateDiscountQueryMother::aValidQueryWithOneItem();

		// Act
		$response = $this->assembler->toDTO($order, $query);

		// Assert
		$this->assertInstanceOf(CalculateDiscountResponse::class, $response);
		$this->assertResponseArrayDataIsValid($query, $order, $response);
	}

	public function testItCreatesAValidResponseWithMultipleItemsAndDiscounts(): void
	{
		//Arrange
		$order = OrderMother::aValidOrderWithMultipleItemsAndDiscounts();
		$query = CalculateDiscountQueryMother::aValidQueryWithMultipleItems();

		// Act
		$response = $this->assembler->toDTO($order, $query);

		// Assert
		$this->assertInstanceOf(CalculateDiscountResponse::class, $response);
		$this->assertResponseArrayDataIsValid($query, $order, $response);
	}

	private function assertResponseArrayDataIsValid(
		CalculateDiscountQuery $query,
		Order $order,
		CalculateDiscountResponse $response
	): void {
		$responseArray = $response->__toArray();
		$this->assertEquals($query->getId(), $responseArray['id']);
		$this->assertEquals($query->getCustomerId(), $responseArray['customer-id']);
		$this->assertSameSize($query->getOrderItems(), $responseArray['original-order']['items']);
		$this->assertEquals($query->getTotal(), $responseArray['original-order']['total']);

		$this->assertSameSize($order->orderItems(), $responseArray['discounted-order']['items']);


		$this->assertEquals($order->total()->__toFloat(), $responseArray['discounted-order']['total']['total']);
		$discounts = $order->discountsAppliedToTotal();
		$this->assertIsString($responseArray['discounted-order']['total']['discounts-applied-to-total']);
		foreach ($discounts as $discount) {
			/** @var AppliedDiscount $discount */
			$this->assertStringContainsString((string)$discount, $responseArray['discounted-order']['total']['discounts-applied-to-total']);
		}
	}
}
