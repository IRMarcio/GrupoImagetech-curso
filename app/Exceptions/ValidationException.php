<?php

namespace App\Exceptions;

use Illuminate\Support\Collection;

class ValidationException extends \Exception
{

    /**
     * @var Collection
     */
    private $errors;

    public function __construct($errors)
    {
        if (!$errors instanceof Collection) {
            $errors = collect([$errors]);
        }

        $this->errors = $errors;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        if ($request->wantsJson()) {
            return response()->json(['data' => ['errors' => $this->errors]], 422);
        }

        // Da flash nas session para exibir na tela
        foreach ($this->errors as $error) {
            flash($error)->error();
        }

        return back()->withInput();
    }
}
