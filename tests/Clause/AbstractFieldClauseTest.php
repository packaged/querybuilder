<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Clause\AbstractFieldClause;
use Packaged\QueryBuilder\Expression\FieldExpression;

class AbstractFieldClauseTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $clause = new FinalAbstractFieldClause();
    $clause->addField((new FieldExpression())->setField('first'));
    $this->assertEquals('T first', $clause->assemble());
    $clause->addField((new FieldExpression())->setField('second'));
    $this->assertEquals('T first, second', $clause->assemble());
    $clause->clearFields();
    $clause->addField((new FieldExpression())->setField('third'));
    $this->assertEquals('T third', $clause->assemble());
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
