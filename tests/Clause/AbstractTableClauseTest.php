<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\AbstractTableClause;

class AbstractTableClauseTest extends \PHPUnit_Framework_TestCase
{
  public function testGettersAndSetters()
  {
    $clause = new FinalAbstractTableClause();
    $clause->setTable('testing');
    $this->assertEquals('testing', $clause->getTable()->getTableName());
  }

  public function testAssemble()
  {
    $clause = new FinalAbstractTableClause();
    $clause->setTable('tester');
    $this->assertEquals('T tester', QueryAssembler::stringify($clause));
  }
}

class FinalAbstractTableClause extends AbstractTableClause
{
  /**
   * @return string
   */
  public function getAction()
  {
    return 'T';
  }
}
