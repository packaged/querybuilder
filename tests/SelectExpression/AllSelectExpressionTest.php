<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\SelectExpression\AllSelectExpression;

class AllSelectExpressionTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $selector = new AllSelectExpression();
    $this->assertEquals('*', QueryAssembler::stringify($selector));
    $selector->setTable('test');
    $this->assertEquals('test.*', QueryAssembler::stringify($selector));
  }

  public function testStatics()
  {
    $this->assertEquals(
      '*',
      QueryAssembler::stringify(AllSelectExpression::create())
    );
    $this->assertEquals(
      'table.*',
      QueryAssembler::stringify(AllSelectExpression::create('table'))
    );
  }
}
