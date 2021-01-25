<?php

namespace Controller;

require_once './Service/PalindromeService.php';
require_once './Service/RedisService.php';
require_once 'APIController.php';

use Service\PalindromeService;
use Service\RedisService;

class PalindromeController extends APIController
{
    /** @var PalindromeService $palindromeService */
    private $palindromeService;

    /** @var RedisService $redisService */
    private $redisService;

    /**
     * PalindromeController constructor.
     * @param $request
     */
    public function __construct($request)
    {
        parent::__construct($request);
        $this->palindromeService = new PalindromeService();
        $this->redisService = new RedisService();
    }

    /**
     * @return string
     */
    public function isPalindrome(): string
    {
        if (!$this->authenticate()) {
            return $this->invalidBearerTokenResponse();
        }

        $requestBody = json_decode($this->request->getBody());
        if (empty($requestBody->word)) {
            return $this->jsonResponse(400, "The field, word can not be empty.");
        }

        $word = $requestBody->word;
        $cacheResult = $this->readFromCache($word);
        if (!is_null($cacheResult)) {
            $result = $cacheResult;
        } else {
            $result = PalindromeService::isPalindrome($word);
            $this->redisService->setValue($word, $result);
        }

        $message = $word . " is not a palindrome.";
        if ($result) {
            $message = $word . " is a palindrome.";
        }
        return $this->jsonResponse(200, $message);
    }

    /**
     * @param string $word
     * @return string|null
     */
    private function readFromCache(string $word): ?string
    {
        if ($this->redisService->valueExists($word)) {
            return $this->redisService->getValue($word);
        }
        return null;
    }
}
