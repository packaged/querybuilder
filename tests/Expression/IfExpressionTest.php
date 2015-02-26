<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\IfExpression;
use Packaged\QueryBuilder\Predicate\EqualPredicate;

class IfExpressionTest extends \PHPUnit_Framework_TestCase
{
  public function testIfExpression()
  {
    $this->assertEquals(
      'IF(test = 4,123,321)',
      QueryAssembler::stringify(
        IfExpression::create(EqualPredicate::create('test', 4), 123, 321)
      )
    );
  }
}
