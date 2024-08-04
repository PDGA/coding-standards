<?php

namespace PDGA\CodingStandards\Sniffs\Attributes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class MatchingNamesSniff implements Sniff
{
    private $called = 1;
    public function register()
    {
        return [
            T_ATTRIBUTE,
            #T_ATTRIBUTE_END,
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $stackPtr = $phpcsFile->findNext(T_STRING, $stackPtr);
        $tokenInfo = $tokens[$stackPtr];

        // Only for Route Attributes,
        // so return if it not one.
        if ($tokenInfo['content'] !== 'Route') {
            return;
        }

        // Get the argument to the Route class
        $stackPtr = $phpcsFile->findNext(T_CONSTANT_ENCAPSED_STRING, $stackPtr);

        if (!$stackPtr) {
            return;
        }

        // Given #[Route(new IntPipe(), 'fooBar')] int $fooBar
        // This is                       ^^^^^^
        $tokenInfo = $tokens[$stackPtr];
        $nameOne = preg_replace('#[^A-Za-z0-9_]#', '', $tokenInfo['content']);

        // Get the name of the variable argument
        $stackPtr = $phpcsFile->findNext(T_VARIABLE, $stackPtr);

        if (!$stackPtr) {
            return;
        }

        // Given #[Route(new IntPipe(), 'fooBar')] int $fooBar
        // This is                                      ^^^^^^
        $tokenInfo = $tokens[$stackPtr];
        $nameTwo = preg_replace('#[^A-Za-z0-9_]#', '', $tokenInfo['content']);

        if ($nameOne === $nameTwo) {
            // No problem, they match like
            // we require for this rule.
            // eg fooBar === fooBar
            return;
        }

        $data = [
            $nameOne,
            $nameTwo
        ];

        $error = "In a PDGA Route attribute, the constructor argument (%s) that represents the variable name (%s) should match.";
        $phpcsFile->addError($error, $stackPtr, 'Route Attribute', $data);
    }
}
