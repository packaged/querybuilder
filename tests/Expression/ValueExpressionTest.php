<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Builder\QueryBuilder;
use Packaged\QueryBuilder\Expression\ValueExpression;

class ValueExpressionTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $expression = new ValueExpression();
    $expression->setValue(1);
    $this->assertEquals('1', QueryAssembler::stringify($expression));
    $expression->setValue('abc');
    $this->assertEquals('"abc"', QueryAssembler::stringify($expression));
  }

  public function testGettersAndSetters()
  {
    $expression = new ValueExpression();
    $expression->setValue(1);
    $this->assertEquals(1, $expression->getValue());
  }

  public function testNull()
  {
    $expression = ValueExpression::create(null);
    $this->assertNull($expression->getValue());
    $this->assertEquals('NULL', QueryAssembler::stringify($expression));

    $stmt = QueryBuilder::update('tbl', ['field' => $expression]);
    $assembler = new QueryAssembler($stmt);
    $this->assertEquals('UPDATE tbl SET field = ?', $assembler->getQuery());
    $this->assertEquals([null], $assembler->getParameters());
  }
}
