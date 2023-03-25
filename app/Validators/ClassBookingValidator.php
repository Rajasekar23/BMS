<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ClassBookingValidator.
 *
 * @package namespace App\Validators;
 */
class ClassBookingValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    // protected $rules = [
    //     ValidatorInterface::RULE_CREATE => [
    //         'class_day_id' => 'required'
    //     ],
    //     ValidatorInterface::RULE_UPDATE => [],
    // ];

    protected $rules = [
        'class_day_id' => 'required',
    ];
}
