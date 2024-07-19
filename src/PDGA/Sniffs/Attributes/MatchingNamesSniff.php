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
        print_r($phpcsFile);
        print_r($stackPtr);
    }
}
