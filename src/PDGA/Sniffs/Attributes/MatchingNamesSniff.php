<?php

namespace PDGA\CodingStandards\Sniffs\Attributes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class MatchingNamesSniff implements Sniff
{
    public function register()
    {
        return [
            T_ATTRIBUTE,
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
        // This is `fooBar`              ^^^^^^
        $tokenInfo = $tokens[$stackPtr];
        $constructorArgName = preg_replace('#[^A-Za-z0-9_]#', '', $tokenInfo['content']);

        // Get the name of the variable argument
        // Given #[Route(new IntPipe(), 'fooBar')] int $fooBar
        // This is                                      ^^^^^^
        $stackPtr = $phpcsFile->findNext(T_VARIABLE, $stackPtr);

        if (!$stackPtr) {
            return;
        }

        // Given #[Route(new IntPipe(), 'fooBar')] int $fooBar
        // This is `fooBar`                             ^^^^^^
        $tokenInfo = $tokens[$stackPtr];
        $variableName = preg_replace('#[^A-Za-z0-9_]#', '', $tokenInfo['content']);

        if ($constructorArgName === $variableName) {
            // No problem, they match like
            // we require for this rule.
            // eg `fooBar` === $fooBar
            return;
        }

        $phpcsFile->addError(
            "In a PDGA Route attribute, the constructor argument ({$constructorArgName}) that represents the variable name ({$variableName}) should match.",
            $stackPtr,
            'Route Attribute'
        );
    }
}
