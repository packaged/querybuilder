<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Builder\QueryBuilder;
use Packaged\QueryBuilder\Expression\AdditionExpression;
use Packaged\QueryBuilder\Predicate\GreaterThanOrEqualPredicate;
use Packaged\QueryBuilder\SelectExpression\ExpressionSelectExpression;
use Packaged\QueryBuilder\SelectExpression\SumSelectExpression;

class ExpressionSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testExpression()
  {
    $this->assertEquals(
      '(SUM(field1) + SUM(field2)) AS sum_field',
      QueryAssembler::stringify(
        ExpressionSelectExpression::createWithAlias(
          AdditionExpression::create(
            SumSelectExpression::create('field1'),
            SumSelectExpression::create('field2')
          ),
          'sum_field'
        )
      )
    );

    $this->assertEquals(
      'SELECT (SUM(field1) + SUM(field2)) AS sum_field FROM tbl HAVING sum_field >= 5',
      QueryAssembler::stringify(
        QueryBuilder::select(
          ExpressionSelectExpression::createWithAlias(
            AdditionExpression::create(
              SumSelectExpression::create('field1'),
              SumSelectExpression::create('field2')
            ),
            'sum_field'
          )
        )->from('tbl')
          ->having(GreaterThanOrEqualPredicate::create('sum_field', 5))
      )
    );
  }
}
