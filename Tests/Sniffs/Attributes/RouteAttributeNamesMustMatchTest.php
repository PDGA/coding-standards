<?php

/**
 * Tests for PDGA Coding Standards.
 */

namespace Tests\Sniffs\Attributes;

use Tests\Helpers\RunPhpCs;
use PHPUnit\Framework\TestCase;

class RouteAttributeNamesMustMatchTest extends TestCase
{
    private RunPhpCs $runPhpCs;

    public function setUp(): void
    {
        $this->runPhpCs = new RunPhpCs();

        parent::setUp();
    }

    // If a
    public function testThatAttributeNamesDoNotMatchIsCaught()
    {
        $result = $this->runPhpCs->process('Tests/Sniffs/Attributes/Targets/attributes-route-non-matching.php');

        $this->assertSame(1, $result['totals']['errors']);
        $this->assertSame(0, $result['totals']['warnings']);
        $this->assertSame(0, $result['totals']['fixable']);
        $this->assertTrue(
            $this
                ->runPhpCs
                ->hasExactError(
                    $result,
                    'In a PDGA Route attribute, the constructor argument (fooBaz) that represents the variable name (foo_baz) should match.',
                )
        );
    }

    public function testThatAttributeNamesThatMatchAreAllowed()
    {
        $result = $this->runPhpCs->process('Tests/Sniffs/Attributes/Targets/attributes-route-matching.php');

        $this->assertSame(0, $result['totals']['errors']);
        $this->assertSame(0, $result['totals']['warnings']);
        $this->assertSame(0, $result['totals']['fixable']);
        $this->assertFalse( // highlighting this is false...
            $this
                ->runPhpCs
                ->hasExactError(
                    $result,
                    'In a PDGA Route attribute, the constructor argument (fooBaz) that represents the variable name (foo_baz) should match.',
                )
        );
    }
}
