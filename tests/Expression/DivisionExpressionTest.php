<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\DivisionExpression;
use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\SelectExpression\FieldSelectExpression;

class DivisionExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $expression = DivisionExpression::create(
      FieldSelectExpression::create('fieldname'),
      NumericExpression::create(4)
    );
    $this->assertEquals(
      '(fieldname / 4)',
      QueryAssembler::stringify($expression)
    );
  }
}
