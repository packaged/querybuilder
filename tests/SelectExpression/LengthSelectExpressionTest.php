<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\SelectExpression\LengthSelectExpression;

class LengthSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new LengthSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals('LEN(fieldname)', QueryAssembler::stringify($selector));
    $selector->setAlias('ln');
    $this->assertEquals(
      'LEN(fieldname) AS ln',
      QueryAssembler::stringify($selector)
    );
  }
}
