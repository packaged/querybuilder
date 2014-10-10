<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\SelectExpression\FormatSelectExpression;

class FormatSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new FormatSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals(
      'FORMAT(fieldname)',
      QueryAssembler::stringify($selector)
    );
    $selector->setAlias('rnd');
    $this->assertEquals(
      'FORMAT(fieldname) AS rnd',
      QueryAssembler::stringify($selector)
    );
    $selector->setPrecision(2);
    $this->assertEquals(
      'FORMAT(fieldname,2) AS rnd',
      QueryAssembler::stringify($selector)
    );
  }

  public function testGettersAndSetters()
  {
    $selector = new FormatSelectExpression();
    $selector->setPrecision(2);
    $this->assertEquals(2, $selector->getPrecision());
  }

  public function testStatics()
  {
    $this->assertEquals(
      'FORMAT(fieldname)',
      QueryAssembler::stringify(FormatSelectExpression::create('fieldname', 0))
    );
    $this->assertEquals(
      'FORMAT(fieldname) AS rnd',
      QueryAssembler::stringify(
        FormatSelectExpression::createWithAlias('fieldname', 'rnd')
      )
    );
    $this->assertEquals(
      'FORMAT(fieldname,2) AS rnd',
      QueryAssembler::stringify(
        FormatSelectExpression::create('fieldname', 2, 'rnd')
      )
    );
  }
}
