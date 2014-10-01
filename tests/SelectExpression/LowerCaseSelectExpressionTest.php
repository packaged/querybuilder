<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\SelectExpression\LowerCaseSelectExpression;

class LowerCaseSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new LowerCaseSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals('LCASE(fieldname)', $selector->assemble());
    $selector->setAlias('lowe');
    $this->assertEquals('LCASE(fieldname) AS lowe', $selector->assemble());
  }
}
