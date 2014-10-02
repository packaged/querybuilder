<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Clause\AbstractTableClause;

class AbstractTableClauseTest extends \PHPUnit_Framework_TestCase
{
  public function testGettersAndSetters()
  {
    $clause = new FinalAbstractTableClause();
    $clause->setTableName('testing');
    $this->assertEquals('testing', $clause->getTableName());
  }

  public function testAssemble()
  {
    $clause = new FinalAbstractTableClause();
    $clause->setTableName('tester');
    $this->assertEquals('T tester', $clause->assemble());
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
