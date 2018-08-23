<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\SelectExpression\CharLengthSelectExpression;

class CharLengthSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new CharLengthSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals('CHAR_LENGTH(fieldname)', QueryAssembler::stringify($selector));
    $selector->setAlias('ln');
    $this->assertEquals(
      'CHAR_LENGTH(fieldname) AS ln',
      QueryAssembler::stringify($selector)
    );
  }
}
