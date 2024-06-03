<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\DecrementExpression;
use Packaged\QueryBuilder\SelectExpression\FieldSelectExpression;

class DecrementExpressionTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $expression = DecrementExpression::create(
      FieldSelectExpression::create('new_field'),
      0
    );
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
