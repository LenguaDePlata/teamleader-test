<?php

declare(strict_types=1);

namespace App\Discounts\Infrastructure\Controller;

use App\Shared\Infrastructure\Validator\RequestValidator;
use Exception;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
			// add the validation rules
		];
	}
}