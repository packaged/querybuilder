<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\SelectExpression\MinSelectExpression;

class MinSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new MinSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals('MIN(fieldname)', $selector->assemble());
    $selector->setAlias('mn');
    $this->assertEquals('MIN(fieldname) AS mn', $selector->assemble());
  }
}
