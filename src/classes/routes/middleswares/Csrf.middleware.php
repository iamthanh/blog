<?php

namespace Blog\Routes\Middlewares;

use Blog\Auth as Auth;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * This handles the verification of csrf tokens in requests
 *
 * Class CsrfMiddleware
 * @package Blog\Routes\Middlewares
 */
class CsrfMiddleware {

    public function __invoke(Request $request, Response $response, $next) {
        $tokenFromRequest = null;
        $body = $request->getParsedBody();
        $queryParams = $request->getQueryParams();
        if (!empty($queryParams['csrfToken'])) {
            $tokenFromRequest = $queryParams['csrfToken'];
        } else if (!empty($body['csrfToken'])) {
            $tokenFromRequest = $body['csrfToken'];
        }

        // Making sure that the request body has the token
        if ($tokenFromRequest) {

            if (Auth::verifyCsrfToken($tokenFromRequest)) {

                // Valid token
                $response = $next($request, $response);
                return $response;
            } else {
                error_log('Error with request: verifyCsrfToken failed');
            }
        } else {
            error_log('Error with request: missing csrf token in request body');
        }

        // csrf token is missing from request
        return $response->withJson([
            'status' => false,
            'message' => 'There was a problem with verifying request token'
        ], 400);
    }

}