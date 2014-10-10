<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\AbstractArithmeticExpression;
use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\Expression\StringExpression;

class AbstractArithmeticExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $expression = new FinalAbstractArithmeticExpression();
    $expression->setExpression(NumericExpression::create(4));
    $expression->setField('fieldname');
    $this->assertEquals(
      'fieldname T 4',
      QueryAssembler::stringify($expression)
    );
  }

  public function testStatics()
  {
    $this->assertEquals(
      'field_name T 5',
      QueryAssembler::stringify(
        FinalAbstractArithmeticExpression::create('field_name', 5)
      )
    );
    $this->assertEquals(
      'field_name T "5"',
      QueryAssembler::stringify(
        FinalAbstractArithmeticExpression::create(
          'field_name',
          StringExpression::create(5)
        )
      )
    );

    $this->assertEquals(
      'tbl.field_name T 5',
      QueryAssembler::stringify(
        FinalAbstractArithmeticExpression::createWithTable(
          'field_name',
          'tbl',
          5
        )
      )
    );

    $this->assertEquals(
      'tbl.field_name T "5"',
      QueryAssembler::stringify(
        FinalAbstractArithmeticExpression::createWithTable(
          'field_name',
          'tbl',
          StringExpression::create(5)
        )
      )
    );
  }
}

class FinalAbstractArithmeticExpression extends AbstractArithmeticExpression
{
  /**
   * Operator e.g. +
   * @return string
   */
  public function getOperator()
  {
    return 'T';
  }
}
