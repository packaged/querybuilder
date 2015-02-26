<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\CaseExpression;
use Packaged\QueryBuilder\Predicate\EqualPredicate;

class CaseExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testCaseExpression()
  {
    $this->assertEquals(
      'CASE WHEN(test = 4) THEN 123 ELSE 321 END',
      QueryAssembler::stringify(
        CaseExpression::create(EqualPredicate::create('test', 4), 123, 321)
      )
    );
  }
}
