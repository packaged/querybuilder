<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\MySQL\MySQLAssembler;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\SelectExpression\MatchSelectExpression;

class MatchSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $expression = MatchSelectExpression::create(
      FieldExpression::createWithTable('field1', 'table1'),
      StringExpression::create('this is a test search')
    );

    $this->assertEquals(
      'MATCH (`table1`.`field1`) AGAINST ("this is a test search")',
      MySQLAssembler::stringify($expression)
    );

    $expression->setAlias('score');
    $this->assertEquals(
      'MATCH (`table1`.`field1`) AGAINST ("this is a test search") AS `score`',
      MySQLAssembler::stringify($expression)
    );
  }
}
