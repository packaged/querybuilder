<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\SelectExpression\AverageSelectExpression;

class AverageSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new AverageSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals('AVG(fieldname)', $selector->assemble());
    $selector->setAlias('aver');
    $this->assertEquals('AVG(fieldname) AS aver', $selector->assemble());
  }
}
