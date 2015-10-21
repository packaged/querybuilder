<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Builder\QueryBuilder;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\IncrementExpression;

class IncrementExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $expression = new IncrementExpression();
    $expression->setField(FieldExpression::create('new_field'));
    $this->assertEquals(
      'new_field + 0',
      QueryAssembler::stringify($expression)
    );
    $expression->setIncrementValue('abc');
    $this->assertEquals(
      'new_field + 0',
      QueryAssembler::stringify($expression)
    );
    $expression->setIncrementValue('1');
    $this->assertEquals(
      'new_field + 1',
      QueryAssembler::stringify($expression)
    );
    $expression->setIncrementValue(1);
    $this->assertEquals(
      'new_field + 1',
      QueryAssembler::stringify($expression)
    );

    $stmt = QueryBuilder::update('tbl');
    $stmt->set('inc_field', $expression);
    $qa = new QueryAssembler($stmt);
    $this->assertEquals(
      'UPDATE tbl SET inc_field = new_field + ?',
      $qa->getQuery()
    );
    $this->assertEquals([1], $qa->getParameters());
  }
}
