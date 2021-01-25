<?php

namespace Helper;

class StringHelper
{
    static public function snackCaseToCamelCase($snakeCase)
    {
        $result = strtolower($snakeCase);
        preg_match_all('/_[a-z]/', $result, $matches);

        foreach ($matches[0] as $match) {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }
}
