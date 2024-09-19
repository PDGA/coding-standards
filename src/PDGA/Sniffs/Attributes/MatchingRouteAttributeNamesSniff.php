<?php

namespace PDGA\CodingStandards\PDGA\Sniffs\Attributes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class MatchingRouteAttributeNamesSniff implements Sniff
{
    protected const TYPE = 'Route';

    public function register(): array
    {
        return [
            T_ATTRIBUTE,
        ];
    }

    public function process(File $phpcsFile, $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();

        $stackPtr = $phpcsFile->findNext(T_STRING, $stackPtr);
        $tokenInfo = $tokens[$stackPtr];

        // Only for Route Attributes,
        // so return if it not one.
        if ($tokenInfo['content'] !== self::TYPE) {
            return;
        }

        // Get the argument to the Route class
        $stackPtr = $phpcsFile->findNext(T_CONSTANT_ENCAPSED_STRING, $stackPtr);

        if (!$stackPtr) {
            return;
        }

        // Given #[Route(new IntPipe(), 'fooBar')] int $fooBar
        // This is `fooBar`              ^^^^^^
        $constructorArgName = $this->getContent($tokens, $stackPtr);

        // Get the name of the variable argument
        // Given #[Route(new IntPipe(), 'fooBar')] int $fooBar
        // This is                                      ^^^^^^
        $stackPtr = $phpcsFile->findNext(T_VARIABLE, $stackPtr);

        if (!$stackPtr) {
            return;
        }

        // Given #[Route(new IntPipe(), 'fooBar')] int $fooBar
        // This is `fooBar`                             ^^^^^^
        $variableName = $this->getContent($tokens, $stackPtr);

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

    private function getContent($tokens, $stackPtr)
    {
        return preg_replace('#[^A-Za-z0-9_]#', '', $tokens[$stackPtr]['content']);
    }
}
