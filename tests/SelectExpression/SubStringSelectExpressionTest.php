<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\SelectExpression\SubStringSelectExpression;

class SubStringSelectExpressionTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $selector = new SubStringSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals(
      'SUBSTRING(fieldname,0)',
      QueryAssembler::stringify($selector)
    );
    $selector->setAlias('new');
    $this->assertEquals(
      'SUBSTRING(fieldname,0) AS new',
      QueryAssembler::stringify($selector)
    );
    $selector->setStartPosition(10);
    $this->assertEquals(
      'SUBSTRING(fieldname,10) AS new',
      QueryAssembler::stringify($selector)
    );
    $selector->setLength(5);
    $this->assertEquals(
      'SUBSTRING(fieldname,10,5) AS new',
      QueryAssembler::stringify($selector)
    );
  }

  public function testStatics()
  {
    $this->assertEquals(
      'SUBSTRING(fieldname,0)',
      QueryAssembler::stringify(SubStringSelectExpression::create('fieldname'))
    );
    $this->assertEquals(
      'SUBSTRING(fieldname,0) AS new',
      QueryAssembler::stringify(
        SubStringSelectExpression::createWithAlias('fieldname', 'new')
      )
    );
    $this->assertEquals(
      'SUBSTRING(fieldname,10) AS new',
      QueryAssembler::stringify(
        SubStringSelectExpression::create('fieldname', 10, null, 'new')
      )
    );
    $this->assertEquals(
      'SUBSTRING(fieldname,10,5) AS new',
      QueryAssembler::stringify(
        SubStringSelectExpression::create('fieldname', 10, 5, 'new')
      )
    );
  }
}
