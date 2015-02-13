<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\CQL\CqlAssembler;
use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\StringExpression;

class StringExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $expression = new StringExpression();
    $expression->setValue(1);
    $this->assertEquals('"1"', QueryAssembler::stringify($expression));
    $expression->setValue('abc');
    $this->assertEquals('"abc"', QueryAssembler::stringify($expression));
    $expression->setValue('a"b"c');
    $this->assertEquals('"a\"b\"c"', QueryAssembler::stringify($expression));

    $expression->setValue('a"b"c');
    $this->assertEquals("'a\"b\"c'", CqlAssembler::stringify($expression));
    $expression->setValue("a'b'c");
    $this->assertEquals("'a''b''c'", CqlAssembler::stringify($expression));
    $expression->setValue("a''b''c");
    $this->assertEquals("'a''''b''''c'", CqlAssembler::stringify($expression));
    $expression->setValue("'a'b'c'");
    $this->assertEquals("'''a''b''c'''", CqlAssembler::stringify($expression));
  }
}
