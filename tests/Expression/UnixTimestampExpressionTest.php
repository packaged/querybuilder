<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Expression\UnixTimestampExpression;

class UnixTimestampExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $expression = new UnixTimestampExpression();
    $this->assertEquals('UNIX_TIMESTAMP()', $expression->assemble());
  }
}
