<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\SelectExpression\TrimSelectExpression;

class TrimSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new TrimSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals(
      'TRIM(fieldname)',
      QueryAssembler::stringify($selector)
    );
    $selector->setAlias('new');
    $this->assertEquals(
      'TRIM(fieldname) AS new',
      QueryAssembler::stringify($selector)
    );
    $selector->setString('~');
    $this->assertEquals(
      'TRIM("~" FROM fieldname) AS new',
      QueryAssembler::stringify($selector)
    );
    $selector->setSide('unknown');
    $this->assertEquals(
      'TRIM("~" FROM fieldname) AS new',
      QueryAssembler::stringify($selector)
    );
    $selector->setSide('trailing');
    $this->assertEquals(
      'TRIM(TRAILING "~" FROM fieldname) AS new',
      QueryAssembler::stringify($selector)
    );
  }

  public function testStatics()
  {
    $this->assertEquals(
      'TRIM(fieldname)',
      QueryAssembler::stringify(TrimSelectExpression::create('fieldname'))
    );
    $this->assertEquals(
      'TRIM(fieldname) AS new',
      QueryAssembler::stringify(TrimSelectExpression::createWithAlias('fieldname', 'new'))
    );
    $this->assertEquals(
      'TRIM("~" FROM fieldname) AS new',
      QueryAssembler::stringify(TrimSelectExpression::create('fieldname', '~', null, 'new'))
    );
    $this->assertEquals(
      'TRIM(LEADING "~" FROM fieldname) AS new',
      QueryAssembler::stringify(TrimSelectExpression::create('fieldname', '~', 'leading', 'new'))
    );
  }
}
