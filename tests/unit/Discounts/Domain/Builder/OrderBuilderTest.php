<?php

declare(strict_types=1);

namespace App\Tests\Unit\Discounts\Domain\Builder;

use App\Discounts\Domain\Builder\OrderBuilder;
use App\Discounts\Domain\Exception\ProductNotFoundException;
use App\Discounts\Domain\Model\Order\Order;
use App\Discounts\Domain\Model\Product\Product;
use App\Discounts\Domain\Repository\ProductRepository;
use App\Discounts\Domain\ValueObject\Product\ProductId;
use App\Tests\Mother\Discounts\OrderItemDTOMother;
use App\Tests\Mother\Discounts\ProductMother;
use PHPUnit\Framework\TestCase;

final class OrderBuilderTest extends TestCase
{
	private const AN_ORDER_ID = 1;
	private const A_CUSTOMER_ID = 1;

	private OrderBuilder $orderBuilder;

	private ProductRepository $productRepositoryMock;

	protected function setUp(): void
	{
		$this->productRepositoryMock = $this->createMock(ProductRepository::class);

		$this->orderBuilder = new OrderBuilder(
			$this->productRepositoryMock
		);
	}

	public function testItBuildsAValidOrder(): void
	{
		// Arrange
		$id = self::AN_ORDER_ID;
		$customerId = self::A_CUSTOMER_ID;
		$orderItemDTOs = [OrderItemDTOMother::aTenSwitchProductItemDTO()];
		$total = $orderItemDTOs[0]->getTotal();

		$product = ProductMother::aSwitchProduct();
		$this->givenTheProductIsFound($product);

		// Act
		$order = $this->orderBuilder->build(
			$id,
			$customerId,
			$orderItemDTOs,
			$total
		);

		// Assert
		$this->assertInstanceOf(Order::class, $order);
		$this->assertOrderDataIsValid(
			$orderItemDTOs,
			$total,
			$order
		);
	}

	public function testItThrowsAnExceptionIfProductDoesNotExist(): void
	{
		// Arrange
		$id = self::AN_ORDER_ID;
		$customerId = self::A_CUSTOMER_ID;
		$orderItemDTOs = [OrderItemDTOMother::aTenSwitchProductItemDTO()];
		$total = $orderItemDTOs[0]->getTotal();

		$this->givenTheProductIsNotFound();
		$this->expectException(ProductNotFoundException::class);

		// Act
		$this->orderBuilder->build(
			$id,
			$customerId,
			$orderItemDTOs,
			$total
		);
	}

	private function givenTheProductIsFound(Product $product): void
	{
		$this->productRepositoryMock
			->expects($this->once())
			->method('findById')
			->with($this->isInstanceOf(ProductId::class))
			->willReturn($product);
	}

	private function givenTheProductIsNotFound(): void
	{
		$this->productRepositoryMock
			->expects($this->once())
			->method('findById')
			->willReturn(null);
	}

	/**
		@param OrderItemDTO[] $orderItemDTOs
	*/
	private function assertOrderDataIsValid(
		array $orderItemDTOs,
		float $total,
		Order $order
	): void {
		$this->assertEquals($total, $order->total()->__toFloat());

		$this->assertEquals(
			$orderItemDTOs[0]->getProductId(),
			$order->orderItems()[0]->product()->id()->__toString()
		);
		$this->assertEquals(
			$orderItemDTOs[0]->getQuantity(),
			$order->orderItems()[0]->quantity()->__toInt()
		);
		$this->assertEquals(
			$orderItemDTOs[0]->getUnitPrice(),
			$order->orderItems()[0]->unitPrice()->__toFloat()
		);
		$this->assertEquals(
			$orderItemDTOs[0]->getTotal(),
			$order->orderItems()[0]->total()->__toFloat()
		);
	}
}
