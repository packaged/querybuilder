<?php
namespace Packaged\QueryBuilder\Clause;

use Packaged\QueryBuilder\Expression\ArrayExpression;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\ValueExpression;
use Packaged\QueryBuilder\Predicate\EqualPredicate;
use Packaged\QueryBuilder\Predicate\InPredicate;
use Packaged\QueryBuilder\Predicate\NotEqualPredicate;
use Packaged\QueryBuilder\Predicate\NotInPredicate;
use Packaged\QueryBuilder\Predicate\OrPredicateSet;
use Packaged\QueryBuilder\Predicate\PredicateInterface;
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

  public static function create(array $predicated)
  {
    $clause = new static;
    $clause->setPredicates(static::buildPredicates($predicated));
    return $clause;
  }

  public static function buildPredicates(
    array $input, $table = null, $inverse = false
  )
  {
    $predicates = [];
    foreach($input as $key => $value)
    {
      if(is_scalar($value))
      {
        $pred = ($inverse ? new NotEqualPredicate() : new EqualPredicate());
        $pred->setField(FieldExpression::create($key, $table));
        $pred->setExpression(ValueExpression::create($value));
        $predicates[] = $pred;
      }
      else if($value instanceof PredicateInterface)
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
          $pred->setField(FieldExpression::create($key, $table));
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
