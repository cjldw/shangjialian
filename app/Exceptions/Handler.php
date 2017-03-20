<?php

namespace App\Exceptions;

use App\Utils\JsonResponseTrait;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    use JsonResponseTrait;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $guards = $exception -> guards();
        $authType = config('auth.authType.mobile');
        $loginUrl = in_array($authType, $guards) ? config('auth.loginUrl.mobile', "/user/login") :
            config('auth.loginUrl.pc', "admin/login");
        return redirect()->guest(url($loginUrl));
    }


    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        /*
        if ($e->response) {
            return $e->response;
        }
        */
        $errors = $e->validator->errors(); //->getMessages();
        $errors = json_decode($errors, true);

        if ($request->expectsJson()) {
            $msg = array_first(array_first($errors));
            return $this -> _sendJsonResponse($msg, $errors, false);
        }
        return redirect()->back()->withInput(
            $request->input()
        )->withErrors($errors);
    }
}
