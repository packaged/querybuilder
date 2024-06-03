<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\UnixTimestampExpression;

class UnixTimestampExpressionTest extends \PHPUnit\Framework\TestCase
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
