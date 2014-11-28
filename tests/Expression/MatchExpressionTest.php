<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\MySQL\MySQLAssembler;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\MatchExpression;
use Packaged\QueryBuilder\Expression\StringExpression;

class MatchExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $expression = MatchExpression::create(
      FieldExpression::createWithTable('field1', 'table1'),
      StringExpression::create('this is a test search')
    );
    $expression->addField(FieldExpression::createWithTable('field2', 'table2'));
    $this->assertEquals(
      'MATCH (`table1`.`field1`,`table2`.`field2`) AGAINST ("this is a test search")',
      MySQLAssembler::stringify($expression)
    );
  }
}
