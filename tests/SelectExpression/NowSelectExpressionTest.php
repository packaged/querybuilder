<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\SelectExpression\NowSelectExpression;

class NowSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new NowSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals('NOW()', QueryAssembler::stringify($selector));
    $selector->setAlias('current');
    $this->assertEquals(
      'NOW() AS current',
      QueryAssembler::stringify($selector)
    );
  }
}
