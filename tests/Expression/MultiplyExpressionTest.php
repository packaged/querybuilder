<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Expression\MultiplyExpression;
use Packaged\QueryBuilder\Expression\NumericExpression;

class MultiplyExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $expression = new MultiplyExpression();
    $expression->setExpression(NumericExpression::create(4));
    $expression->setField('fieldname');
    $this->assertEquals('fieldname * 4', $expression->assemble());
  }
}
