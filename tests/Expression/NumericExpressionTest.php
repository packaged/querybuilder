<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Expression\NumericExpression;

class NumericExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $expression = new NumericExpression();
    $expression->setValue(1);
    $this->assertEquals('1', $expression->assemble());
    $expression->setValue('abc');
    $this->assertEquals('abc', $expression->assemble());
  }
}
