<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\SelectExpression\CountSelectExpression;

class CountSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new CountSelectExpression();
    $this->assertEquals(
      'COUNT(*)',
      QueryAssembler::stringify($selector)
    );
    $selector->setField('fieldname');
    $this->assertEquals(
      'COUNT(fieldname)',
      QueryAssembler::stringify($selector)
    );
    $selector->setAlias('cnt');
    $this->assertEquals(
      'COUNT(fieldname) AS cnt',
      QueryAssembler::stringify($selector)
    );
    $selector->setDistinct();
    $this->assertEquals(
      'COUNT(DISTINCT fieldname) AS cnt',
      QueryAssembler::stringify($selector)
    );
  }
}
