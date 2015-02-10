<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\BooleanExpression;
use Packaged\QueryBuilder\Expression\ValueExpression;

class BooleanExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testBoolean()
  {
    $expression = new BooleanExpression();
    $expression->setValue(true);
    $this->assertEquals(1, QueryAssembler::stringify($expression));
    $expression->setValue(1);
    $this->assertEquals(1, QueryAssembler::stringify($expression));
    $expression->setValue('abc');
    $this->assertEquals(1, QueryAssembler::stringify($expression));

    $expression->setValue(false);
    $this->assertEquals(0, QueryAssembler::stringify($expression));
    $expression->setValue(0);
    $this->assertEquals(0, QueryAssembler::stringify($expression));
    $expression->setValue('');
    $this->assertEquals(0, QueryAssembler::stringify($expression));
  }

  public function testBooleanValue()
  {
    $expression = new ValueExpression();
    $expression->setValue(true);
    $this->assertEquals(1, QueryAssembler::stringify($expression));
    $expression->setValue(false);
    $this->assertEquals(0, QueryAssembler::stringify($expression));
  }
}
