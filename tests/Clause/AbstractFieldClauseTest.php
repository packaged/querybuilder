<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\AbstractFieldClause;
use Packaged\QueryBuilder\Expression\FieldExpression;

class AbstractFieldClauseTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $clause = new FinalAbstractFieldClause();
    $clause->addField((new FieldExpression())->setField('first'));
    $this->assertEquals('T first', QueryAssembler::stringify($clause));
    $clause->addField((new FieldExpression())->setField('second'));
    $this->assertEquals('T first, second', QueryAssembler::stringify($clause));
    $clause->clearFields();
    $clause->addField((new FieldExpression())->setField('third'));
    $this->assertEquals('T third', QueryAssembler::stringify($clause));
  }
}

class FinalAbstractFieldClause extends AbstractFieldClause
{
  /**
   * @return string
   */
  public function getAction()
  {
    return 'T';
  }
}
