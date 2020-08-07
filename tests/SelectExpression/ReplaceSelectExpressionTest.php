<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\SelectExpression\ReplaceSelectExpression;

class ReplaceSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new ReplaceSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals(
      'REPLACE(fieldname,"","")',
      QueryAssembler::stringify($selector)
    );
    $selector->setAlias('new');
    $this->assertEquals(
      'REPLACE(fieldname,"","") AS new',
      QueryAssembler::stringify($selector)
    );
    $selector->setSearchString('~');
    $this->assertEquals(
      'REPLACE(fieldname,"~","") AS new',
      QueryAssembler::stringify($selector)
    );
    $selector->setReplaceString('-');
    $this->assertEquals(
      'REPLACE(fieldname,"~","-") AS new',
      QueryAssembler::stringify($selector)
    );
  }

  public function testStatics()
  {
    $this->assertEquals(
      'REPLACE(fieldname,"","")',
      QueryAssembler::stringify(ReplaceSelectExpression::create('fieldname'))
    );
    $this->assertEquals(
      'REPLACE(fieldname,"","") AS new',
      QueryAssembler::stringify(ReplaceSelectExpression::createWithAlias('fieldname', 'new'))
    );
    $this->assertEquals(
      'REPLACE(fieldname,"~","") AS new',
      QueryAssembler::stringify(ReplaceSelectExpression::create('fieldname', '~', null, 'new'))
    );
    $this->assertEquals(
      'REPLACE(fieldname,"~","-") AS new',
      QueryAssembler::stringify(ReplaceSelectExpression::create('fieldname', '~', '-', 'new'))
    );
  }
}
