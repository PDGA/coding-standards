<?php

namespace Tests\Helpers;

class RunPhpCs
{
    public function process(string $against)
    {
        $dir = $this->getTestsDirectory();
        $exec = $this->getExecutableString($dir, $against);

        $return = [];
        exec($exec, $return);

        return json_decode(implode('', $return), true);
    }

    public function hasExactError(array $result, string $errorMessage): bool
    {
        $hasExactError = false;

        array_walk_recursive($result, function($item, $key) use ($errorMessage, &$hasExactError) {
            if ($key === 'message' && $item === $errorMessage) {
                $hasExactError = true;
                return;
            }
        });

        return $hasExactError;
    }

    private function getExecutableString(string $dir, string $against)
    {
        return "{$dir}/vendor/bin/phpcs --standard=./src/PDGA,./src/ruleset.xml {$against} --report=json";
    }

    private function getTestsDirectory()
    {
        // This is where `vendor` will be
        return realpath(__DIR__ . '/../../');
    }
}
