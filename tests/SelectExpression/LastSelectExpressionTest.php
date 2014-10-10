<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\SelectExpression\LastSelectExpression;

class LastSelectExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $selector = new LastSelectExpression();
    $selector->setField('fieldname');
    $this->assertEquals(
      'LAST(fieldname)',
      QueryAssembler::stringify($selector)
    );
    $selector->setAlias('lst');
    $this->assertEquals(
      'LAST(fieldname) AS lst',
      QueryAssembler::stringify($selector)
    );
  }
}
