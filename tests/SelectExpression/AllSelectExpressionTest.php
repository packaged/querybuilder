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

  public function testStatics()
  {
    $this->assertEquals('*', AllSelectExpression::create()->assemble());
    $this->assertEquals(
      'table.*',
      AllSelectExpression::create('table')->assemble()
    );
  }
}
