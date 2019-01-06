<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function class_basename;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
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
     * @param  Request  $request
     * @param  \Exception  $exception
     * @return Response
     */
    public function render($request, Exception $exception)
    {        
        if($exception instanceof ValidationException)
        {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }
        
        if($exception instanceof ModelNotFoundException)
        {
            $modelo = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("No existe ninguna instancia de {$modelo} con el id especificado", 404);
        }
        
        if ($exception instanceof AuthorizationException) {
            return $this->unauthenticated($request, $exception);
        }
        
        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse('No posee permisos para ejecutar esta acción', 403);
        }
        
        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('No se encontró la URL especificada', 404);
        }
        
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('El método especificado en la petición no es válido', 405);
        }
        
        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(),$exception->getStatusCode());
        }
        
        if ($exception instanceof QueryException) {
           $codigo = $exception->errorInfo[1];
           
           if($codigo == 1451){
               return $this->errorResponse('No se puede eleminiar de forma permanentemente '
                       . 'el recurso por que está relacionado con algún otro', 409);
           }            
        }
        
        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        return $this->errorResponse('Fallo inesperado', 500);
    }
    
    /**
     * Convert an authentication exception into a response.
     *
     * @param  Request  $request
     * @param  AuthenticationException  $exception
     * @return Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse('No autenticado', 401);
    }
    
    protected  function convertValidationExceptionToResponse(ValidationException $e, $request) {
        $errors = $e->validator->errors()->getMessages();
        
        return $this->errorResponse($errors,442);
    }
    
}
