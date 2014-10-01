<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\SelectExpression\CountSelectExpression;

class CountSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new CountSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals('COUNT(fieldname)', $selector->assemble());
    $selector->setAlias('cnt');
    $this->assertEquals('COUNT(fieldname) AS cnt', $selector->assemble());
  }
}
