<?php
namespace Packaged\Tests\QueryBuilder\Expression\CQL;

use Packaged\QueryBuilder\Assembler\CQL\CqlAssembler;
use Packaged\QueryBuilder\Expression\CQL\ListExpression;
use Packaged\QueryBuilder\Expression\CQL\ListFieldExpression;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\SubtractExpression;
use Packaged\QueryBuilder\Predicate\EqualPredicate;

class ListExpressionTest extends \PHPUnit\Framework\TestCase
{
  public function testListExpression()
  {
    $this->assertEquals(
      "['test',1]",
      CqlAssembler::stringify(ListExpression::create(['test', 1]))
    );

    $this->assertEquals(
      "\"testfield\" - ['test']",
      CqlAssembler::stringify(
        SubtractExpression::create(
          FieldExpression::create('testfield'),
          ListExpression::create('test')
        )
      )
    );
  }

  public function testListFieldExpression()
  {
    $this->assertEquals(
      "myfield[5] = 'test'",
      CqlAssembler::stringify(
        EqualPredicate::create(
          ListFieldExpression::create('myfield', 5),
          'test'
        )
      )
    );
  }

  /**
   * @expectedException \InvalidArgumentException
   * @expectedExceptionMessage Key must be numeric for ListFieldExpression
   */
  public function testFailListFieldExpression()
  {
    EqualPredicate::create(
      ListFieldExpression::create('myfield', 'test'),
      'test'
    );
  }
}
