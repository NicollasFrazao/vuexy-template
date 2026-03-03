<?php

namespace Tests;

/**
 * Base class for property-based tests using Eris.
 *
 * Overrides getTestCaseAnnotations() to fix compatibility with PHPUnit 11,
 * which removed PHPUnit\Util\Test::parseTestMethodAnnotations().
 */
abstract class PropertyTestCase extends TestCase
{
    /**
     * Override Eris's getTestCaseAnnotations to fix PHPUnit 11 compatibility.
     * PHPUnit 11 removed PHPUnit\Util\Test::parseTestMethodAnnotations().
     * We return an empty array since we don't use Eris annotation-based configuration.
     *
     * @return array
     */
    public function getTestCaseAnnotations()
    {
        return [];
    }
}
