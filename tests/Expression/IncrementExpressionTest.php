<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Expression\IncrementExpression;

class IncrementExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $expression = new IncrementExpression();
    $expression->setField('new_field');
    $this->assertEquals('new_field + 0', $expression->assemble());
    $expression->setIncrementValue('abc');
    $this->assertEquals('new_field + 0', $expression->assemble());
    $expression->setIncrementValue('1');
    $this->assertEquals('new_field + 1', $expression->assemble());
    $expression->setIncrementValue(1);
    $this->assertEquals('new_field + 1', $expression->assemble());
  }
}
