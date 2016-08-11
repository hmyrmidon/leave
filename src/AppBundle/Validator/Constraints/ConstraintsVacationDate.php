<?php

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class ConstraintsVacationDate
 * @package AppBundle\Validator\Constraints
 * @Annotation
 */
class ConstraintsVacationDate extends Constraint
{
    public $message = "it's not a valid date";

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}