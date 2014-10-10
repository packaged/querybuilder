<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\UnixTimestampExpression;

class UnixTimestampExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $expression = new UnixTimestampExpression();
    $this->assertEquals(
      'UNIX_TIMESTAMP()',
      QueryAssembler::stringify($expression)
    );
  }
}
