<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Builder\QueryBuilder;
use Packaged\QueryBuilder\Expression\BooleanExpression;
use Packaged\QueryBuilder\Expression\ValueExpression;

class BooleanExpressionTest extends \PHPUnit\Framework\TestCase
{
  public function testBoolean()
  {
    $expression = new BooleanExpression();
    $expression->setValue(true);
    $this->assertEquals('true', QueryAssembler::stringify($expression));
    $expression->setValue(1);
    $this->assertEquals('true', QueryAssembler::stringify($expression));
    $expression->setValue('abc');
    $this->assertEquals('true', QueryAssembler::stringify($expression));

    $expression->setValue(false);
    $this->assertEquals('false', QueryAssembler::stringify($expression));
    $expression->setValue(0);
    $this->assertEquals('false', QueryAssembler::stringify($expression));
    $expression->setValue('');
    $this->assertEquals('false', QueryAssembler::stringify($expression));

    $stmt = QueryBuilder::update('tbl', ['field' => $expression]);
    $assembler = new QueryAssembler($stmt);
    $this->assertEquals('UPDATE tbl SET field = ?', $assembler->getQuery());
    $this->assertEquals([false], $assembler->getParameters());
  }

  public function testBooleanValue()
  {
    $expression = new ValueExpression();
    $expression->setValue(true);
    $this->assertEquals('true', QueryAssembler::stringify($expression));
    $expression->setValue(false);
    $this->assertEquals('false', QueryAssembler::stringify($expression));
  }
}
