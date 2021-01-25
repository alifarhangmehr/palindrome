<?php

namespace Service;

class PalindromeService
{
    static public function isPalindrome($word) : bool
    {
        $word = mb_strtolower($word);
        $word = str_replace(" ", "", $word);
        $wordArray = mb_str_split($word);
        $palindrome = '';
        for ($i = strlen($word) - 1; $i >= 0; $i--) {
            $palindrome .= $wordArray[$i];
        }
        return $word == $palindrome;
    }
}
