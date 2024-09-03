<?php

declare(strict_types=1);

namespace App\Discounts\Infrastructure\Controller;

use App\Shared\Infrastructure\Validator\RequestValidator;
use Exception;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

final class CalculateDiscount extends AbstractController
{
	use RequestValidator;

	public function __invoke(Request $request): JsonResponse
	{
		try {
			$decodedRequest = json_decode($request->getContent(), true);
			$this->ensureRequestIsValid($decodedRequest, $this->constraints());
			// TODO: call the use case
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
		} catch(Exception $e) {
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
				new Assert\Type('array')
			]),
			'items.*.product-id' => new Assert\Required([
				new Assert\NotBlank(),
				new Assert\Type('string')
			]),
			'items.*.quantity' => new Assert\Required([
				new Assert\NotBlank(),
				new Assert\Type('numeric'),
				new Assert\Positive()
			]),
			'items.*.unit-price' => new Assert\Required([
				new Assert\NotBlank(),
				new Assert\Type('numeric'),
				new Assert\PositiveOrZero()
			]),
			'items.*.total' => new Assert\Required([
				new Assert\NotBlank(),
				new Assert\Type('numeric'),
				new Assert\PositiveOrZero()
			]),
			'total' => new Assert\Required([
				new Assert\NotBlank(),
				new Assert\Type('numeric'),
				new Assert\PositiveOrZero()
			])
		];
	}
}