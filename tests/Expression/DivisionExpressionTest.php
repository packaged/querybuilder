<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Expression\DivisionExpression;
use Packaged\QueryBuilder\Expression\NumericExpression;

class DivisionExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $expression = new DivisionExpression();
    $expression->setExpression(NumericExpression::create(4));
    $expression->setField('fieldname');
    $this->assertEquals('fieldname / 4', $expression->assemble());
  }
}
