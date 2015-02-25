<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Assembler\Segments\ExpressionAssembler;
use Packaged\QueryBuilder\Expression\AbstractArithmeticExpression;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\IExpression;
use Packaged\QueryBuilder\Expression\StringExpression;

class AbstractArithmeticExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $expression = FinalAbstractArithmeticExpression::create(
      FieldExpression::create('fieldname'),
      4
    );
    $this->assertEquals(
      '(fieldname T 4)',
      QueryAssembler::stringify($expression)
    );
  }

  public function testStatics()
  {
    $this->assertEquals(
      '(field_name T 5)',
      QueryAssembler::stringify(
        FinalAbstractArithmeticExpression::create(
          FieldExpression::create('field_name'),
          5
        )
      )
    );
    $this->assertEquals(
      '(field_name T 5)',
      QueryAssembler::stringify(
        FinalAbstractArithmeticExpression::create(
          FieldExpression::create('field_name'),
          StringExpression::create(5)
        )
      )
    );

    $this->assertEquals(
      '(tbl.field_name T 5)',
      QueryAssembler::stringify(
        FinalAbstractArithmeticExpression::create(
          FieldExpression::createWithTable('field_name', 'tbl'),
          5
        )
      )
    );

    $this->assertEquals(
      '(tbl.field_name T 5)',
      QueryAssembler::stringify(
        FinalAbstractArithmeticExpression::create(
          FieldExpression::createWithTable('field_name', 'tbl'),
          StringExpression::create(5)
        )
      )
    );
  }

  /**
   * @expectedException \RuntimeException
   * @expectedExceptionMessage Unsupported segment
   */
  public function testUnknown()
  {
    $assembler = new ExpressionAssembler(new UnknownExpression());
    $assembler->assemble();
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

class UnknownExpression implements IExpression
{
}
