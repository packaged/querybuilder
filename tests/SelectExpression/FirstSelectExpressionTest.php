<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\SelectExpression\FirstSelectExpression;

class FirstSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new FirstSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals('FIRST(fieldname)', $selector->assemble());
    $selector->setAlias('fst');
    $this->assertEquals('FIRST(fieldname) AS fst', $selector->assemble());
  }
}
