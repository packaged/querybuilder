<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\SelectExpression\LengthSelectExpression;

class LengthSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new LengthSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals('LEN(fieldname)', $selector->assemble());
    $selector->setAlias('ln');
    $this->assertEquals('LEN(fieldname) AS ln', $selector->assemble());
  }
}
