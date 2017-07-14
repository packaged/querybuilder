<?php
namespace Packaged\Tests\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\Like\ContainsExpression;
use Packaged\QueryBuilder\Expression\Like\CustomLikeExpression;
use Packaged\QueryBuilder\Expression\Like\EndsWithExpression;
use Packaged\QueryBuilder\Expression\Like\StartsWithExpression;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Predicate\LikeBinaryPredicate;

class LikeBinaryPredicateTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $predicate = new LikeBinaryPredicate();
    $predicate->setField('field');
    $this->assertEquals(
      'field LIKE BINARY NULL',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setExpression(CustomLikeExpression::create(1));
    $this->assertEquals(
      'field LIKE BINARY 1',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setExpression(CustomLikeExpression::create('1'));
    $this->assertEquals(
      'field LIKE BINARY "1"',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setExpression(CustomLikeExpression::create('abc'));
    $this->assertEquals(
      'field LIKE BINARY "abc"',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setExpression(EndsWithExpression::create('abc'));
    $this->assertEquals(
      'field LIKE BINARY "%abc"',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setExpression(ContainsExpression::create('abc'));
    $this->assertEquals(
      'field LIKE BINARY "%abc%"',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setExpression(StartsWithExpression::create('abc'));
    $this->assertEquals(
      'field LIKE BINARY "abc%"',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setExpression(CustomLikeExpression::create('a%bc'));
    $this->assertEquals(
      'field LIKE BINARY "a%bc"',
      QueryAssembler::stringify($predicate)
    );

    $predicate = LikeBinaryPredicate::create('field', 'a%bc');
    $this->assertEquals(
      'field LIKE BINARY "a%bc"',
      QueryAssembler::stringify($predicate)
    );

    $predicate = LikeBinaryPredicate::create(
      'field',
      StartsWithExpression::create('abc')
    );
    $this->assertEquals(
      'field LIKE BINARY "abc%"',
      QueryAssembler::stringify($predicate)
    );
  }

  /**
   * @expectedException \Exception
   * @expectedExceptionMessage Invalid Expression Type
   */
  public function testInvalidExpression()
  {
    $predicate = new LikeBinaryPredicate();
    $predicate->setField('field');
    $predicate->setExpression(StringExpression::create('a%bc'));
  }
}
