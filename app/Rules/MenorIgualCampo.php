<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * O campo sendo validado tem que ser menor ou igual ao campo especificado no constructor.
 *
 * @package App\Rules
 */
class MenorIgualCampo implements Rule
{

    /**
     * @var string
     */
    private $campo;

    /**
     * @var string
     */
    private $attribute;

    public function __construct($campo)
    {
        $this->campo = $campo;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->attribute = $attribute;

        return $value <= request($this->campo);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $campo = trans('validation.attributes.' . $this->attribute);
        $outro = trans('validation.attributes.' . $this->campo);

        return "O campo $campo tem que ser menor ou igual ao campo $outro";
    }
}
