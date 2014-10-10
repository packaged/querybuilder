<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\SelectExpression\ConcatSelectExpression;

class ConcatSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new ConcatSelectExpression();
    $selector->setProperties('one', 'two');
    $this->assertEquals(
      'CONCAT(one,two)',
      QueryAssembler::stringify($selector)
    );
    $selector->setProperties('one', "'-'", 'two');
    $this->assertEquals(
      'CONCAT(one,\'-\',two)',
      QueryAssembler::stringify($selector)
    );
  }

  public function testStatics()
  {
    $this->assertEquals(
      'CONCAT(one,two)',
      QueryAssembler::stringify(ConcatSelectExpression::create('one', 'two'))
    );
    $this->assertEquals(
      'CONCAT(one,\'-\',two)',
      QueryAssembler::stringify(
        ConcatSelectExpression::create('one', "'-'", 'two')
      )
    );
  }
}
