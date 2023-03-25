<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\ClassBooking;

/**
 * Class ClassBookingTransformer.
 *
 * @package namespace App\Transformers;
 */
class ClassBookingTransformer extends TransformerAbstract
{
    /**
     * Transform the ClassBooking entity.
     *
     * @param \App\Entities\ClassBooking $model
     *
     * @return array
     */
    public function transform(ClassBooking $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
