<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\SelectExpression\SumSelectExpression;

class SumSelectExpressionTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $selector = new SumSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals('SUM(fieldname)', QueryAssembler::stringify($selector));
    $selector->setAlias('cnt');
    $this->assertEquals(
      'SUM(fieldname) AS cnt',
      QueryAssembler::stringify($selector)
    );
  }
}
