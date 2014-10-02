<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\SelectExpression\FormatSelectExpression;

class FormatSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new FormatSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals('FORMAT(fieldname)', $selector->assemble());
    $selector->setAlias('rnd');
    $this->assertEquals('FORMAT(fieldname) AS rnd', $selector->assemble());
    $selector->setPrecision(2);
    $this->assertEquals('FORMAT(fieldname,2) AS rnd', $selector->assemble());
  }

  public function testGettersAndSetters()
  {
    $selector = new FormatSelectExpression();
    $selector->setPrecision(2);
    $this->assertEquals(2, $selector->getPrecision());
  }
}
