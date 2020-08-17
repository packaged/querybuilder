<?php
namespace Packaged\Tests\QueryBuilder\Expression\CQL;

use Packaged\QueryBuilder\Assembler\CQL\CqlAssembler;
use Packaged\QueryBuilder\Expression\AdditionExpression;
use Packaged\QueryBuilder\Expression\CQL\SetExpression;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Predicate\EqualPredicate;

class SetExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testSetExpression()
  {
    $this->assertEquals(
      "{'test',1}",
      CqlAssembler::stringify(SetExpression::create(['test', 1]))
    );

    $this->assertEquals(
      "\"testfield\" + {'test'}",
      CqlAssembler::stringify(
        AdditionExpression::create(
          FieldExpression::create('testfield'),
          SetExpression::create('test')
        )
      )
    );
  }

  public function testSetExpressionPrepared()
  {
    $assembler = new CqlAssembler();
    $this->assertEquals(
      "?",
      $assembler->assembleSegment(SetExpression::create(['test', 1]))
    );
    $this->assertEquals([['test', 1]], $assembler->getParameters());

    $assembler = new CqlAssembler();
    $this->assertEquals(
      "\"testfield\" + ?",
      $assembler->assembleSegment(
        AdditionExpression::create(
          FieldExpression::create('testfield'),
          SetExpression::create('test')
        )
      )
    );
    $this->assertEquals([['test']], $assembler->getParameters());

    $assembler = new CqlAssembler();
    $this->assertEquals(
      "\"testfield\" = \"testfield\" + ?",
      $assembler->assembleSegment(
        EqualPredicate::create(
          'testfield',
          AdditionExpression::create(
            FieldExpression::create('testfield'),
            SetExpression::create('test')
          )
        )
      )
    );
    $this->assertEquals([['test']], $assembler->getParameters());
  }
}
