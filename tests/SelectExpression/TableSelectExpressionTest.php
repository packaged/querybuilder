<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\MySQL\MySQLAssembler;
use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\TableExpression;
use Packaged\QueryBuilder\SelectExpression\TableSelectExpression;

class TableSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $sel1 = TableSelectExpression::create('table_one');
    $this->assertEquals('`table_one`', MySQLAssembler::stringify($sel1));
    $sel1->setAlias('t1');
    $this->assertEquals(
      '`table_one` AS `t1`',
      MySQLAssembler::stringify($sel1)
    );

    $sel2 = new TableSelectExpression();
    $sel2->setTable('table_two');
    $this->assertEquals('table_two', QueryAssembler::stringify($sel2));
    $sel2->setAlias('t2');
    $this->assertEquals(
      'table_two AS t2',
      QueryAssembler::stringify($sel2)
    );

    $sel3 = TableSelectExpression::createWithAlias(
      TableExpression::create('table_three'),
      't3'
    );
    $this->assertEquals(
      '`table_three` AS `t3`',
      MySQLAssembler::stringify($sel3)
    );
  }
}
