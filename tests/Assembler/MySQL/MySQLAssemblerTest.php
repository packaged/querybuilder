<?php
namespace Packaged\Tests\QueryBuilder\Assembler\MySQL;

use Packaged\QueryBuilder\Assembler\MySQL\MySQLAssembler;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\TableExpression;

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
}
