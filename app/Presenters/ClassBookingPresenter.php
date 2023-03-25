<?php

namespace App\Presenters;

use App\Transformers\ClassBookingTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ClassBookingPresenter.
 *
 * @package namespace App\Presenters;
 */
class ClassBookingPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ClassBookingTransformer();
    }
}
