<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Expression\DecrementExpression;

class DecrementExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $expression = new DecrementExpression();
    $expression->setField('new_field');
    $this->assertEquals('new_field - 0', $expression->assemble());
    $expression->setDecrementValue('abc');
    $this->assertEquals('new_field - 0', $expression->assemble());
    $expression->setDecrementValue('1');
    $this->assertEquals('new_field - 1', $expression->assemble());
    $expression->setDecrementValue(1);
    $this->assertEquals('new_field - 1', $expression->assemble());
  }
}
