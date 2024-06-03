<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\MultiplyExpression;
use Packaged\QueryBuilder\Expression\NumericExpression;

class MultiplyExpressionTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $expression = MultiplyExpression::create(
      FieldExpression::create('fieldname'),
      NumericExpression::create(4)
    );
    $this->assertEquals(
      '(fieldname * 4)',
      QueryAssembler::stringify($expression)
    );
  }
}
