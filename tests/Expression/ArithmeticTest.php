<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\AdditionExpression;
use Packaged\QueryBuilder\Expression\SubtractExpression;
use Packaged\QueryBuilder\SelectExpression\SumSelectExpression;

class ArithmeticTest extends \PHPUnit\Framework\TestCase
{
  public function testArithmetic()
  {
    $this->assertEquals(
      '(5 + (10 - 5))',
      QueryAssembler::stringify(
        AdditionExpression::create(
          5,
          SubtractExpression::create(10, 5)
        )
      )
    );

    $this->assertEquals(
      '(SUM(amt) + (10 - 5))',
      QueryAssembler::stringify(
        AdditionExpression::create(
          SumSelectExpression::create('amt'),
          SubtractExpression::create(10, 5)
        )
      )
    );
  }
}
