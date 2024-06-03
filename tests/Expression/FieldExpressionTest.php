<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\FieldExpression;

class FieldExpressionTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $expression = new FieldExpression();
    $expression->setField('new_field');
    $this->assertEquals('new_field', QueryAssembler::stringify($expression));
  }

  public function testSettersAndGetters()
  {
    $expression = new FieldExpression();
    $expression->setField('new_field');
    $this->assertEquals('new_field', QueryAssembler::stringify($expression));
  }
}
