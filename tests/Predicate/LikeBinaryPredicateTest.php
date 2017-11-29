<?php
namespace Packaged\Tests\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\Like\ContainsExpression;
use Packaged\QueryBuilder\Expression\Like\CustomLikeExpression;
use Packaged\QueryBuilder\Expression\Like\EndsWithExpression;
use Packaged\QueryBuilder\Expression\Like\StartsWithExpression;
use Packaged\QueryBuilder\Predicate\LikePredicate;

class LikeBinaryPredicateTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $predicate = new LikePredicate();
    $predicate->setBinary(true);
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

    $predicate = LikePredicate::create('field', 'a%bc');
    $predicate->setBinary(true);
    $this->assertEquals(
      'field LIKE BINARY "a%bc"',
      QueryAssembler::stringify($predicate)
    );

    $predicate = LikePredicate::create(
      'field',
      StartsWithExpression::create('abc')
    );
    $predicate->setBinary(true);
    $this->assertEquals(
      'field LIKE BINARY "abc%"',
      QueryAssembler::stringify($predicate)
    );
  }
}
