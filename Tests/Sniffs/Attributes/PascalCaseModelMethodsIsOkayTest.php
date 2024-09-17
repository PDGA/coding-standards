<?php

/**
 * Tests for PDGA Coding Standards.
 */

namespace Tests\Sniffs\Attributes;

use Tests\Helpers\RunPhpCs;
use PHPUnit\Framework\TestCase;

class PascalCaseModelMethodsIsOkayTest extends TestCase
{
    private RunPhpCs $runPhpCs;

    public function setUp(): void
    {
        $this->runPhpCs = new RunPhpCs();

        parent::setUp();
    }

    /**
     * In a non-model file (not *Model.php), continue to only allow
     * camelCase method names.
     */
    public function testThatPascalCasingAMethodInANonModelFileWillStillShowError()
    {
        $result = $this->runPhpCs->process('Tests/Sniffs/Attributes/Targets/PascalCaseNotModelFile.php');

        $this->assertSame(1, $result['totals']['errors']);
        $this->assertSame(0, $result['totals']['warnings']);
        $this->assertSame(0, $result['totals']['fixable']);
        $this->assertTrue(
            $this
                ->runPhpCs
                ->hasExactError(
                    $result,
                    // Since this is on `ModelFile.php` ^^^ above ^^^, the disabling of this
                    // rule does not apply and we expect this error:
                    'Method name "NotModel::FakeMethodForError" is not in camel caps format',
                )
        );
    }

    /**
     * In the normal PSR all method names should be camelCase. In PDGA, relationship
     * method names *on model files* (eg *Model.php) are Pascal Case.
     */
    public function testThatPascalCasingAMethodInAModelFileWillBePermitted()
    {
        $result = $this->runPhpCs->process('Tests/Sniffs/Attributes/Targets/PascalCaseIgnoreBecauseModel.php');

        $this->assertSame(0, $result['totals']['errors']);
        $this->assertSame(0, $result['totals']['warnings']);
        $this->assertSame(0, $result['totals']['fixable']);
    }

    /**
     * In the normal PSR all method names should be camelCase. In PDGA, relationship
     * method names *on model files* (eg *Model.php) are Pascal Case. However, we still
     * permit camelCase on method names in model files.
     */
    public function testThatCamelCasingAMethodInAModelFileWillStillBePermitted()
    {
        $result = $this->runPhpCs->process('Tests/Sniffs/Attributes/Targets/CamelCaseValidModel.php');

        $this->assertSame(0, $result['totals']['errors']);
        $this->assertSame(0, $result['totals']['warnings']);
        $this->assertSame(0, $result['totals']['fixable']);
    }
}
