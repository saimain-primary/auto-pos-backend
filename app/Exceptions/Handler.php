<?php

namespace App\Exceptions;

use App\Traits\JsonApiResponseTrait;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;

class Handler extends ExceptionHandler
{

    use JsonApiResponseTrait;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Add this custom handler for AuthenticationException
        $this->renderable(function (AuthenticationException $e, $request) {
            return $this->unauthenticated($request, $e);
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // Check if the request expects a JSON response
        if ($request->expectsJson()) {
            // Return a custom JSON response
            return $this->errorResponse('Unauthorized', 401);
        }

        // Redirect the user to the login page for non-API requests
        return redirect()->guest(route('login'));
    }
}
