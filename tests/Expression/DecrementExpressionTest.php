<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\DecrementExpression;

class DecrementExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $expression = new DecrementExpression();
    $expression->setField('new_field');
    $this->assertEquals(
      'new_field - 0',
      QueryAssembler::stringify($expression)
    );
    $expression->setDecrementValue('abc');
    $this->assertEquals(
      'new_field - 0',
      QueryAssembler::stringify($expression)
    );
    $expression->setDecrementValue('1');
    $this->assertEquals(
      'new_field - 1',
      QueryAssembler::stringify($expression)
    );
    $expression->setDecrementValue(1);
    $this->assertEquals(
      'new_field - 1',
      QueryAssembler::stringify($expression)
    );
  }
}
