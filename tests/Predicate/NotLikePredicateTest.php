<?php
namespace Packaged\Tests\QueryBuilder\Predicate;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\Like\ContainsExpression;
use Packaged\QueryBuilder\Expression\Like\CustomLikeExpression;
use Packaged\QueryBuilder\Expression\Like\EndsWithExpression;
use Packaged\QueryBuilder\Expression\Like\StartsWithExpression;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Predicate\NotLikePredicate;

class NotLikePredicateTest extends \PHPUnit_Framework_TestCase
{
  public function testAssemble()
  {
    $predicate = new NotLikePredicate();
    $predicate->setField('field');
    $this->assertEquals(
      'field NOT LIKE NULL',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setExpression(CustomLikeExpression::create(1));
    $this->assertEquals(
      'field NOT LIKE "1"',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setExpression(CustomLikeExpression::create('1'));
    $this->assertEquals(
      'field NOT LIKE "1"',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setExpression(CustomLikeExpression::create('abc'));
    $this->assertEquals(
      'field NOT LIKE "abc"',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setExpression(EndsWithExpression::create('abc'));
    $this->assertEquals(
      'field NOT LIKE "abc%"',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setExpression(ContainsExpression::create('abc'));
    $this->assertEquals(
      'field NOT LIKE "%abc%"',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setExpression(StartsWithExpression::create('abc'));
    $this->assertEquals(
      'field NOT LIKE "%abc"',
      QueryAssembler::stringify($predicate)
    );
    $predicate->setExpression(CustomLikeExpression::create('a%bc'));
    $this->assertEquals(
      'field NOT LIKE "a%bc"',
      QueryAssembler::stringify($predicate)
    );
  }

  /**
   * @expectedException \Exception
   * @expectedExceptionMessage Invalid Expression Type
   */
  public function testInvalidExpression()
  {
    $predicate = new NotLikePredicate();
    $predicate->setField('field');
    $predicate->setExpression(StringExpression::create('a%bc'));
  }
}
