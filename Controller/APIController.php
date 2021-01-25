<?php

namespace Controller;

require_once './Service/UserService.php';

use Service\UserService;

class APIController
{
    protected $request;

    /** @var UserService $userService */
    private $userService;

    /**
     * APIController constructor.
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $request;
        $this->userService = new UserService();
    }

    /**
     * @return bool
     */
    protected function authenticate(): bool
    {
        if (isset($this->request->httpAuthorization)) {
            $token = $this->getBearerTokenFromRequest($this->request);
            if ($this->userService->validateToken($token)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Todo this can be moved to StringHelper
     * @param $request
     * @return string
     */
    protected function getBearerTokenFromRequest($request): string
    {
        return str_replace("Bearer ", "", $request->httpAuthorization);
    }

    /**
     * @param int $code
     * @param string|null $message
     * @return string
     */
    protected function jsonResponse(int $code = 200, ?string $message = null): string
    {
        header_remove();
        http_response_code($code);

        if (!headers_sent()) {
            header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
            header('Content-Type: application/json');
        }

        $status = [
            200 => '200 OK',
            400 => '400 Bad Request',
            401 => '401 Unauthorized Request',
            422 => '422 Unprocessable Entity',
            409 => '409 Conflict',
            500 => '500 Internal Server Error'
        ];
        if (!headers_sent()) {
            header('Status: ' . $status[$code]);
        }

        return json_encode([
            'status' => $code < 300, // success or failure
            'message' => $message
        ]);
    }

    /**
     * @return string
     */
    protected function generalErrorJsonResponse(): string
    {
        return $this->jsonResponse("500", "We are sorry, something went wrong.");
    }

    /**
     * @return string
     */
    protected function invalidBearerTokenResponse() : string
    {
        return $this->jsonResponse(401, "Bearer token is not valid.");
    }
}
