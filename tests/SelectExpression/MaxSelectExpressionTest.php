<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\SelectExpression\MaxSelectExpression;

class MaxSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new MaxSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals('MAX(fieldname)', QueryAssembler::stringify($selector));
    $selector->setAlias('mx');
    $this->assertEquals(
      'MAX(fieldname) AS mx',
      QueryAssembler::stringify($selector)
    );
  }
}
