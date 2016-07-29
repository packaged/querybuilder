<?php
namespace Packaged\Tests\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Predicate\RegexpPredicate;

class RegexpPredicateTest extends \PHPUnit_Framework_TestCase
{
  public function testRegexpPredicate()
  {
    $pred = RegexpPredicate::create('field1', '^Test "value" [0-9]+ .*$');
    $this->assertEquals(
      'field1 REGEXP "^Test \"value\" [0-9]+ .*$"',
      QueryAssembler::stringify($pred)
    );
  }
}
