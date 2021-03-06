<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\QueryBuilder\Expression\ArrayExpression;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\ValueExpression;
use Packaged\QueryBuilder\Predicate\EqualPredicate;
use Packaged\QueryBuilder\Predicate\InPredicate;
use Packaged\QueryBuilder\Predicate\IPredicate;
use Packaged\QueryBuilder\Predicate\NotEqualPredicate;
use Packaged\QueryBuilder\Predicate\NotInPredicate;
use Packaged\QueryBuilder\Predicate\OrPredicateSet;
use Packaged\QueryBuilder\Predicate\PredicateSet;

class WhereClause extends AbstractPredicateClause
{
  /**
   * @return string
   */
  public function getAction()
  {
    return 'WHERE';
  }

  public static function create(array $predicated = null)
  {
    $clause = new static;
    if($predicated !== null)
    {
      $clause->setPredicates(static::buildPredicates($predicated));
    }
    return $clause;
  }

  public static function buildPredicates(
    array $input, $table = null, $inverse = false
  )
  {
    $predicates = [];
    foreach($input as $key => $value)
    {
      if($value === null || is_scalar($value)
        || $value instanceof ValueExpression
      )
      {
        $pred = ($inverse ? new NotEqualPredicate() : new EqualPredicate());
        $pred->setField(FieldExpression::createWithTable($key, $table));
        if(!($value instanceof ValueExpression))
        {
          $value = ValueExpression::create($value);
        }
        $pred->setExpression($value);
        $predicates[] = $pred;
      }
      else if($value instanceof IPredicate)
      {
        $predicates[] = $value;
      }
      else if(is_array($value))
      {
        if(is_int($key))
        {
          $predicates = array_merge(
            $predicates,
            static::buildPredicates($value, $table, $inverse)
          );
        }
        else if(static::_isControlKeyword($key))
        {
          switch($key)
          {
            case 'NOT':
              $predicates = array_merge(
                $predicates,
                static::buildPredicates($value, $table, true)
              );
              break;
            case 'OR':
              $pred = new OrPredicateSet();
              $pred->setPredicates(
                static::buildPredicates($value, $table, $inverse)
              );
              $predicates[] = $pred;
              break;
            case 'AND':
              $pred = new PredicateSet();
              $pred->setPredicates(
                static::buildPredicates($value, $table, $inverse)
              );
              $predicates[] = $pred;
              break;
          }
        }
        else
        {
          $pred = ($inverse ? new NotInPredicate() : new InPredicate());
          $pred->setField(FieldExpression::createWithTable($key, $table));
          $pred->setExpression(ArrayExpression::create($value));
          $predicates[] = $pred;
        }
      }
    }
    return $predicates;
  }

  protected static function _isControlKeyword($key)
  {
    return in_array($key, ['NOT', 'AND', 'OR']);
  }
}
