<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\SelectExpression\ConcatSelectExpression;

class ConcatSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new ConcatSelectExpression();
    $selector->setProperties('one', 'two');
    $this->assertEquals('CONCAT(one,two)', $selector->assemble());
    $selector->setProperties('one', "'-'", 'two');
    $this->assertEquals('CONCAT(one,\'-\',two)', $selector->assemble());
  }

  public function testStatics()
  {
    $this->assertEquals(
      'CONCAT(one,two)',
      ConcatSelectExpression::create('one', 'two')->assemble()
    );
    $this->assertEquals(
      'CONCAT(one,\'-\',two)',
      ConcatSelectExpression::create('one', "'-'", 'two')->assemble()
    );
  }
}
