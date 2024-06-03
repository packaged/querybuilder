<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\SelectExpression\LengthSelectExpression;

class LengthSelectExpressionTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $selector = new LengthSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals('LENGTH(fieldname)', QueryAssembler::stringify($selector));
    $selector->setAlias('ln');
    $this->assertEquals(
      'LENGTH(fieldname) AS ln',
      QueryAssembler::stringify($selector)
    );
  }
}
