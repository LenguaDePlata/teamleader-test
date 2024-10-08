<?php

declare(strict_types=1);

namespace App\Discounts\Infrastructure\Controller;

use App\Discounts\Application\DTO\OrderItemDTO;
use App\Discounts\Application\Exception\UnexpectedDiscountErrorException;
use App\Discounts\Application\Exception\ProductNotFoundException;
use App\Discounts\Application\Query\CalculateDiscount\CalculateDiscountHandler;
use App\Discounts\Application\Query\CalculateDiscount\CalculateDiscountQuery;
use App\Shared\Infrastructure\Validator\RequestValidator;
use Exception;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

final class CalculateDiscountController extends AbstractController
{
	use RequestValidator;

	public function __construct(
		private CalculateDiscountHandler $calculateDiscountHandler
	) {}

	public function __invoke(Request $request): JsonResponse
	{
		try {
			$decodedRequest = json_decode($request->getContent(), true);
			$this->ensureRequestIsValid($decodedRequest, $this->constraints());
			$response = $this->calculateDiscountHandler->handle(new CalculateDiscountQuery(
				(int)$decodedRequest['id'],
				(int)$decodedRequest['customer-id'],
				array_map(
					function(array $item) {
						return new OrderItemDTO(
							$item['product-id'],
							(int)$item['quantity'],
							(float)$item['unit-price'],
							(float)$item['total']
						);
					},
					$decodedRequest['items']
				),
				(float)$decodedRequest['total']
			));
			return $this->json(
				$response->__toArray(),
				JsonResponse::HTTP_OK
			); 
		} catch(InvalidJsonException $e) {
			return $this->json(
				$e->getMessage(),
				JsonResponse::HTTP_BAD_REQUEST
			);
		} catch(InvalidArgumentException $e) {
			return $this->json(
				$this->getViolationsArray(),
				JsonResponse::HTTP_BAD_REQUEST
			);
		} catch(ProductNotFoundException $e) {
			return $this->json(
				['error' => $e->getMessage()],
				JsonResponse::HTTP_NOT_FOUND
			);
		} catch(UnexpectedDiscountErrorException|Exception $e) {
			return $this->json(
				['error' => $e->getMessage()],
				JsonResponse::HTTP_INTERNAL_SERVER_ERROR
			);
		}
	}

	private function constraints(): array
	{
		return [
			'id' => new Assert\Required([
				new Assert\NotBlank(),
				new Assert\Type('numeric'),
				new Assert\Positive()
			]),
			'customer-id' => new Assert\Required([
				new Assert\NotBlank(),
				new Assert\Type('numeric'),
				new Assert\Positive()
			]),
			'items' => new Assert\Required([
				new Assert\NotBlank(),
				new Assert\Type('array'),
				new Assert\Count(['min' => 1]),
        		new Assert\All([
        			new Assert\Collection([
        				'product-id' => new Assert\Required([
        					new Assert\NotBlank(),
        					new Assert\Type('string')
        				]),
        				'quantity' => new Assert\Required([
        					new Assert\NotBlank(),
        					new Assert\Type('numeric'),
        					new Assert\Positive()
        				]),
        				'unit-price' => new Assert\Required([
        					new Assert\NotBlank(),
        					new Assert\Type('numeric'),
        					new Assert\PositiveOrZero()
        				]),
        				'total' => new Assert\Required([
        					new Assert\NotBlank(),
        					new Assert\Type('numeric'),
        					new Assert\PositiveOrZero()
        				])
        			]),
        		])
			]),
			'total' => new Assert\Required([
				new Assert\NotBlank(),
				new Assert\Type('numeric'),
				new Assert\PositiveOrZero()
			])
		];
	}
}