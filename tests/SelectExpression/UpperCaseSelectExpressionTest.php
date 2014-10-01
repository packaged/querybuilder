<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\SelectExpression\UpperCaseSelectExpression;

class UpperCaseSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new UpperCaseSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals('UCASE(fieldname)', $selector->assemble());
    $selector->setAlias('upper');
    $this->assertEquals('UCASE(fieldname) AS upper', $selector->assemble());
  }
}
