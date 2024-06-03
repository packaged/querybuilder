<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\SelectExpression\LowerCaseSelectExpression;

class LowerCaseSelectExpressionTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $selector = new LowerCaseSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals(
      'LCASE(fieldname)',
      QueryAssembler::stringify($selector)
    );
    $selector->setAlias('lowe');
    $this->assertEquals(
      'LCASE(fieldname) AS lowe',
      QueryAssembler::stringify($selector)
    );
  }
}
