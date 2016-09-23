<?php

namespace AppBundle\Validator\Constraints;


use AppBundle\Entity\VacationRequest;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ConstraintsVacationDateValidator extends ConstraintValidator
{

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed      $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if($value->getReturnDate() < $value->getStartDate()){
            $this->context->buildViolation($constraint->message)
                ->atPath('returnDate')
                ->addViolation();
        }
    }
}