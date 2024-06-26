<?php

namespace Outl1ne\MenuBuilder\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Route;

class RouteExists implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Route::has($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Provided route name doesn't exist.";
    }
}
