<?php
namespace Packaged\Tests\QueryBuilder\Clause;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Clause\DuplicateKeyClause;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Predicate\EqualPredicate;

class DuplicateKeyClauseTest extends \PHPUnit\Framework\TestCase
{
  public function testDuplicateKey()
  {
    $clause = new DuplicateKeyClause();
    $clause->addPredicate(
      EqualPredicate::create('field1', FieldExpression::create('field2'))
    );
    $clause->addPredicate(EqualPredicate::create('field3', 5));
    $this->assertEquals(
      'ON DUPLICATE KEY UPDATE field1 = field2, field3 = 5',
      QueryAssembler::stringify($clause)
    );
  }
}
