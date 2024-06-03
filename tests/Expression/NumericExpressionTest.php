<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\NumericExpression;

class NumericExpressionTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $expression = new NumericExpression();
    $expression->setValue(1);
    $this->assertEquals('1', QueryAssembler::stringify($expression));
    $expression->setValue('1a');
    $this->assertEquals('1', QueryAssembler::stringify($expression));
    $expression->setValue(1.2);
    $this->assertEquals('1.2', QueryAssembler::stringify($expression));
    $expression->setValue('abc');
    $this->assertEquals('0', QueryAssembler::stringify($expression));
  }
}
