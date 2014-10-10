<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\ValueExpression;

class ValueExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $expression = new ValueExpression();
    $expression->setValue(1);
    $this->assertEquals('1', QueryAssembler::stringify($expression));
    $expression->setValue('abc');
    $this->assertEquals('"abc"', QueryAssembler::stringify($expression));
  }

  public function testGettersAndSetters()
  {
    $expression = new ValueExpression();
    $expression->setValue(1);
    $this->assertEquals(1, $expression->getValue());
  }
}
