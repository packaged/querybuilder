<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\SelectExpression\MinSelectExpression;

class MinSelectExpressionTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $selector = new MinSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals('MIN(fieldname)', QueryAssembler::stringify($selector));
    $selector->setAlias('mn');
    $this->assertEquals(
      'MIN(fieldname) AS mn',
      QueryAssembler::stringify($selector)
    );
  }
}
