<?php

require_once './vendor/autoload.php';
require_once './Service/PalindromeService.php';

use PHPUnit\Framework\TestCase;
use Service\PalindromeService;

class PalindromeServiceTest extends TestCase
{
    public function setup(): void
    {
        parent::setup();
    }

    /**
     * @test
     */
    public function isPalindrome_true(): void
    {
        $word = 'dad';
        $actual = $palindromeService = PalindromeService::isPalindrome($word);
        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function isPalindrome_false(): void
    {
        $word = 'not palindrome';
        $actual = $palindromeService = PalindromeService::isPalindrome($word);
        $this->assertFalse($actual);
    }
}
