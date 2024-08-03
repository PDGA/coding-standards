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
        // print_r($tokens);
        // exit;

        // Once we hit the T_ATRIBUTE, which is where we are here,
        // we can use that to ->findNext for the pieces of a PDGA-route attribut.

        $stackPtr = $phpcsFile->findNext(T_STRING, $stackPtr);
        $tokenInfo = $tokens[$stackPtr];

        // Only for Route Attributes
        if ($tokenInfo['content'] !== 'Route') {
            return;
        }

        // Get the argument to the validator <<< probably need to check for the newed-up class, too, like IntPipe
        $stackPtr = $phpcsFile->findNext(T_CONSTANT_ENCAPSED_STRING, $stackPtr);

        if (!$stackPtr) {
            return;
        }

        $tokenInfo = $tokens[$stackPtr];
        $nameOne = preg_replace('#[^A-Za-z0-9_]#', '', $tokenInfo['content']);


        // Get the name of the variable argument
        $stackPtr = $phpcsFile->findNext(T_VARIABLE, $stackPtr);

        if (!$stackPtr) {
            return;
        }

        $tokenInfo = $tokens[$stackPtr];
        $nameTwo = preg_replace('#[^A-Za-z0-9_]#', '', $tokenInfo['content']);

        echo "{$nameOne} !== {$nameTwo}" . PHP_EOL;

        if ($nameOne !== $nameTwo) {
            echo ('ERROR');
        }

        print_r($tokenInfo);
        // Advance pointer
        #$stackPtr = strlen($attributeClass) + $stackPtr;

        // Then
        // T_OPEN_PARENTHESIS
        // T_NEW
        // T_WHITESPACE
        // T_STRING (IntPipe)
        // T_OPEN_PARANTHESIS
        // T_CLOSE_PARANTHESIS
        // T_COMMA
        // T_WHITESPACE
        // T_CONSTANT_ENCAPSED_STRING (foobaz)
        // T_CLOSE_PARENTHESIS
        // ...

        // Could, after T_ATTRIBUTE is found, look for `T_CONSTANT_ENCAPSED_STRING` for that, then next T_VARIABLE for
        // that.
        // Also could try getting it all, then running through a tokenizer of it's own. But that means worrying about
        // newlines, etc
        /*
$tokens = PhpToken::tokenize("<?php $thas = 'that';");

print_r($tokens);

foreach ($tokens as $token) {
    echo "Line {$token->line}: {$token->getTokenName()} ('{$token->text}')", PHP_EOL;
}

        */


        $nextString = $phpcsFile->findNext(T_CONSTANT_ENCAPSED_STRING, $stackPtr);
        echo "YO" . $nextString.PHP_EOL;
        $nextAttrEndPtr = $phpcsFile->findNext(T_ATTRIBUTE_END, $stackPtr);
        $contents = $phpcsFile->getTokensAsString($stackPtr, ($nextAttrEndPtr - $stackPtr));
        // NEXT, T_VARIABLE
        //     $nextEndOfArg = $phpcsFile->findNext(T_VARIABLE, $stackPtr);
        // // search for end of string T_COMMA or T_CLOSE_PARANTHESES
        // $contents = $phpcsFile->getTokensAsString($stackPtr, (($nextEndOfArg+1) - $stackPtr));
        // how do I find the end without the +1                         ^^^^

        // print_r([$stackPtr, $nextAttrEndPtr, $contents]);
        // print_r($stackPtr);

        // $matches = [];
        // preg_match('##', $contents, $matches);
        // print_r([
        //     $contents,
        //     $matches
        // ]);
    }
}
