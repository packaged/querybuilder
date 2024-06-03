<?php
namespace Packaged\Tests\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Expression\TableExpression;
use Packaged\QueryBuilder\Expression\Traits\TableTrait;
use Packaged\QueryBuilder\SelectExpression\TableSelectExpression;
use Packaged\QueryBuilder\Statement\AbstractStatement;

class TableTraitTest extends \PHPUnit\Framework\TestCase
{
  public function testGetTable()
  {
    $statement = new FinalTableTrait();
    $statement->setTable(null);
    $this->assertNull($statement->getTable());

    $table = TableSelectExpression::create('table_one');
    $table->setAlias('t1');

    $statement = new FinalTableTrait();
    $statement->setTable($table);
    $this->assertInstanceOf(TableExpression::class, $statement->getTable());
  }
}

class FinalTableTrait extends AbstractStatement
{
  use TableTrait;

  protected function _getOrder()
  {
    return ["FROM"];
  }
}
