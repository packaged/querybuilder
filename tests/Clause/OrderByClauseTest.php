<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\OrderByClause;
use Packaged\QueryBuilder\Expression\FieldExpression;

class OrderByClauseTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $clause = new OrderByClause();
    $clause->addField((new FieldExpression())->setField('first'));
    $this->assertEquals('ORDER BY first', QueryAssembler::stringify($clause));
    $clause->clearFields();
    $clause->addField((new FieldExpression())->setField('first'), 'ASC');
    $this->assertEquals(
      'ORDER BY first ASC',
      QueryAssembler::stringify($clause)
    );
    $clause->clearFields();
    $clause->addField((new FieldExpression())->setField('first'), 'DESC');
    $this->assertEquals(
      'ORDER BY first DESC',
      QueryAssembler::stringify($clause)
    );
    $clause->addField((new FieldExpression())->setField('second'), 'ASC');
    $this->assertEquals(
      'ORDER BY first DESC, second ASC',
      QueryAssembler::stringify($clause)
    );
  }
}
