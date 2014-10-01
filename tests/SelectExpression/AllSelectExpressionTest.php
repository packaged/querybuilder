<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\SelectExpression\AllSelectExpression;

class AllSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new AllSelectExpression();
    $this->assertEquals('*', $selector->assemble());
    $selector->setTable('test');
    $this->assertEquals('test.*', $selector->assemble());
  }
}
