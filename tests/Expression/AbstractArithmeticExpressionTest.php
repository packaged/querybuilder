<?php
namespace Packaged\Tests\QueryBuilder\Expression;

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
    $this->assertEquals('fieldname T 4', $expression->assemble());
  }

  public function testStatics()
  {
    $this->assertEquals(
      'field_name T 5',
      FinalAbstractArithmeticExpression::create('field_name', 5)->assemble()
    );
    $this->assertEquals(
      'field_name T "5"',
      FinalAbstractArithmeticExpression::create(
        'field_name',
        StringExpression::create(5)
      )->assemble()
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
