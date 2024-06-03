<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Assembler\Segments\ClauseAssembler;
use Packaged\QueryBuilder\Clause\AbstractTableClause;
use Packaged\QueryBuilder\Clause\IClause;

class AbstractTableClauseTest extends \PHPUnit\Framework\TestCase
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

  /**
   * @expectedException \RuntimeException
   * @expectedExceptionMessage Unsupported segment
   */
  public function testUnknown()
  {
    $assembler = new ClauseAssembler(new UnknownClause());
    $assembler->assemble();
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

class UnknownClause implements IClause
{
  public function getAction()
  {
  }

  public function allowMultiple()
  {
  }
}
