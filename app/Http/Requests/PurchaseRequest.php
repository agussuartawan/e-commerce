<?php

namespace App\Http\Requests;

use App\Rules\ArrayAtLeastOne;
use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => [new ArrayAtLeastOne()],
            'qty' => [new ArrayAtLeastOne()],
            'production_price' => [new ArrayAtLeastOne()],
        ];
    }
}
