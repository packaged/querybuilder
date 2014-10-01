<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\SelectExpression\SubStringSelectExpression;

class SubStringSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new SubStringSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals('SUBSTRING(fieldname,0)', $selector->assemble());
    $selector->setAlias('new');
    $this->assertEquals('SUBSTRING(fieldname,0) AS new', $selector->assemble());
    $selector->setStartPosition(10);
    $this->assertEquals(
      'SUBSTRING(fieldname,10) AS new',
      $selector->assemble()
    );
    $selector->setLength(5);
    $this->assertEquals(
      'SUBSTRING(fieldname,10,5) AS new',
      $selector->assemble()
    );
  }
}
