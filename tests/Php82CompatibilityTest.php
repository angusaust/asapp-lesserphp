<?php

require_once __DIR__ . '/../lessc.inc.php';

use PHPUnit\Framework\TestCase;

class Php82CompatibilityTest extends TestCase
{
    public function testCompilerRetainsGlobalApiAndExpectedCss()
    {
        $compiler = new lessc();
        $this->assertSame(".animal {\n  width: 6px;\n}\n", $compiler->compile('@size: 3px; .animal { width: @size * 2; }'));
        $this->assertInstanceOf('lessc_parser', $compiler->parser);
        foreach ([
            'lessc' => ['_parseFile', 'env', 'formatter', 'formatterName', 'parser', 'scope'],
            'lessc_parser' => ['buffer', 'count', 'currentProperty', 'eatWhiteDefault', 'env', 'inExp', 'lessc', 'line', 'seenComments', 'sourceName', 'writeComments'],
            'lessc_formatter_classic' => ['indentLevel'],
        ] as $class => $properties) {
            foreach ($properties as $property) {
                $this->assertTrue((new \ReflectionProperty($class, $property))->isPublic());
            }
        }
    }
}
