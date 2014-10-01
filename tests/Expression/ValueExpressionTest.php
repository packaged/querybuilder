<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Expression\ValueExpression;

class ValueExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $expression = new ValueExpression();
    $expression->setValue(1);
    $this->assertEquals('1', $expression->assemble());
    $expression->setValue('abc');
    $this->assertEquals('"abc"', $expression->assemble());
  }

  public function testGettersAndSetters()
  {
    $expression = new ValueExpression();
    $expression->setValue(1);
    $this->assertEquals(1, $expression->getValue());
  }
}
