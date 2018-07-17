<?php
namespace Packaged\Tests\QueryBuilder\Assembler\MySQL;

use Packaged\QueryBuilder\Assembler\MySQL\MySQLAssembler;
use Packaged\QueryBuilder\Builder\QueryBuilder;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Expression\TableExpression;
use Packaged\QueryBuilder\Predicate\GreaterThanPredicate;
use Packaged\QueryBuilder\SelectExpression\FieldSelectExpression;
use Packaged\QueryBuilder\SelectExpression\MatchSelectExpression;
use Packaged\QueryBuilder\SelectExpression\MaxSelectExpression;
use Packaged\QueryBuilder\SelectExpression\SubQuerySelectExpression;

class MySQLAssemblerTest extends \PHPUnit_Framework_TestCase
{
  public function testTableName()
  {
    $this->assertEquals(
      '`mytable`.`myfield`',
      MySQLAssembler::stringify(
        FieldExpression::createWithTable('myfield', 'mytable')
      )
    );
    $this->assertEquals(
      '`mytable`',
      MySQLAssembler::stringify(
        TableExpression::create('mytable')
      )
    );
  }

  public function testFieldName()
  {
    $this->assertEquals(
      '`myfield`',
      MySQLAssembler::stringify(
        FieldExpression::create('myfield')
      )
    );
  }

  public function testSelectField()
  {
    $this->assertEquals(
      '`myfield` AS `unique`',
      MySQLAssembler::stringify(
        FieldSelectExpression::createWithAlias('myfield', 'unique')
      )
    );
  }

  public function testSubQuery()
  {
    $subQuery = QueryBuilder::select(
      FieldSelectExpression::create('articleFid'),
      MatchSelectExpression::create(FieldExpression::create('term'), StringExpression::create('search'))
        ->setAlias('score')
    )
      ->from('search_terms')
      ->having(GreaterThanPredicate::create('score', 0));

    $subQueryText = 'SELECT `articleFid`, MATCH (`term`) AGAINST ("search") AS `score` FROM `search_terms` HAVING `score` > 0';
    $this->assertEquals($subQueryText, MySQLAssembler::stringify($subQuery));

    $query = QueryBuilder::select(
      FieldSelectExpression::create('articleFid'),
      MaxSelectExpression::createWithAlias('score', 'score')
    )
      ->from(SubQuerySelectExpression::create($subQuery, 'x'))
      ->groupBy('articleFid')->orderBy(['score' => 'DESC']);
    $this->assertEquals(
      'SELECT `articleFid`, MAX(`score`) AS `score` FROM (' . $subQueryText . ') AS `x` GROUP BY `articleFid` ORDER BY `score` DESC',
      MySQLAssembler::stringify($query)
    );
  }
}
