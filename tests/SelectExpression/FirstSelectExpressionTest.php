<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\SelectExpression\FirstSelectExpression;

class FirstSelectExpressionTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $selector = new FirstSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals(
      'FIRST(fieldname)',
      QueryAssembler::stringify($selector)
    );
    $selector->setAlias('fst');
    $this->assertEquals(
      'FIRST(fieldname) AS fst',
      QueryAssembler::stringify($selector)
    );
  }
}
