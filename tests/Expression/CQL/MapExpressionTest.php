<?php
namespace Packaged\Tests\QueryBuilder\Expression\CQL;

use Packaged\QueryBuilder\Assembler\CQL\CqlAssembler;
use Packaged\QueryBuilder\Expression\AdditionExpression;
use Packaged\QueryBuilder\Expression\CQL\MapExpression;
use Packaged\QueryBuilder\Expression\CQL\MapFieldExpression;
use Packaged\QueryBuilder\Expression\CQL\SetExpression;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Predicate\EqualPredicate;

class MapExpressionTest extends \PHPUnit\Framework\TestCase
{
  /**
   * @expectedException \InvalidArgumentException
   * @expectedExceptionMessage Map requires an associative array
   */
  public function testFailSetExpression()
  {
    CqlAssembler::stringify(MapExpression::create('test'));
  }

  public function testSetExpression()
  {
    $this->assertEquals(
      "{'test':'myval','test2':2}",
      CqlAssembler::stringify(
        MapExpression::create(['test' => 'myval', 'test2' => 2])
      )
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

  public function testMapFieldExpression()
  {
    $this->assertEquals(
      "myfield['mykey'] = 'test'",
      CqlAssembler::stringify(
        EqualPredicate::create(
          MapFieldExpression::create('myfield', 'mykey'),
          'test'
        )
      )
    );
  }
}
