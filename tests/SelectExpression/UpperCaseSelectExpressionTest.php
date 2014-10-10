<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\SelectExpression\UpperCaseSelectExpression;

class UpperCaseSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new UpperCaseSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals(
      'UCASE(fieldname)',
      QueryAssembler::stringify($selector)
    );
    $selector->setAlias('upper');
    $this->assertEquals(
      'UCASE(fieldname) AS upper',
      QueryAssembler::stringify($selector)
    );
  }
}
