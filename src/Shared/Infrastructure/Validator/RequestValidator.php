<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Validator;

use App\Shared\Infrastructure\Exception\InvalidJsonException;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validation;

trait RequestValidator
{
	private ConstraintViolationListInterface $violations;

	protected function ensureRequestIsValid(?array $input, array $constraints): void
    {
        if (is_null($input)) {
            throw new InvalidJsonException();
        }
        $validator = Validation::createValidator();
        $constraintCollection = new Collection($constraints);
        $this->violations = $validator->validate($input, $constraintCollection);
        if ($violations->count() > 0) {
            throw new InvalidArgumentException('Invalid arguments: '. (string)$violations);
        }
    }

    protected function getViolationsArray(): array
    {
    	$violationsArray = [];
    	foreach ($this->violations as $violation) {
    		$violationsArray[$violation->getPropertyPath()] = $violation->getMessage() . '('. $violation->getInvalidValue() .')';
    	}
    	return $violationsArray;
    }
}