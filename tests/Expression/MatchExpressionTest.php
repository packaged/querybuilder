<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\MySQL\MySQLAssembler;
use Packaged\QueryBuilder\Builder\QueryBuilder;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\MatchExpression;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Predicate\GreaterThanPredicate;
use Packaged\QueryBuilder\SelectExpression\AllSelectExpression;

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

    $expression->setSearchModifier(MatchExpression::BOOLEAN_MODE);
    $this->assertEquals(
      'MATCH (`table1`.`field1`,`table2`.`field2`) AGAINST ("this is a test search" IN BOOLEAN MODE)',
      MySQLAssembler::stringify($expression)
    );

    $expression->setSearchModifier(MatchExpression::WITH_QUERY_EXPANSION);
    $this->assertEquals(
      'MATCH (`table1`.`field1`,`table2`.`field2`) AGAINST ("this is a test search" WITH QUERY EXPANSION)',
      MySQLAssembler::stringify($expression)
    );

    $expression->setSearchModifier(MatchExpression::BOOLEAN_MODE);
    $stmt = QueryBuilder::select(AllSelectExpression::create())->from('tbl')
      ->where(GreaterThanPredicate::create($expression, 0))->limit(5);
    $assembler = new MySQLAssembler($stmt);
    $this->assertEquals(
      'SELECT * FROM `tbl` WHERE MATCH (`table1`.`field1`,`table2`.`field2`) AGAINST (? IN BOOLEAN MODE) > ? LIMIT ?',
      $assembler->getQuery()
    );
    $this->assertEquals(
      ['this is a test search', 0, 5],
      $assembler->getParameters()
    );
  }
}
