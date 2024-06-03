<?php
namespace Packaged\Tests\QueryBuilder\Expression\CQL;

use Packaged\QueryBuilder\Assembler\CQL\CqlAssembler;
use Packaged\QueryBuilder\Expression\AdditionExpression;
use Packaged\QueryBuilder\Expression\CQL\SetExpression;
use Packaged\QueryBuilder\Expression\FieldExpression;

class SetExpressionTest extends \PHPUnit\Framework\TestCase
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
}
