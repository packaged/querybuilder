<?php
namespace Packaged\QueryBuilder\Assembler\Segments;

use Packaged\QueryBuilder\Expression\AbstractArithmeticExpression;
use Packaged\QueryBuilder\Expression\ArrayExpression;
use Packaged\QueryBuilder\Expression\BooleanExpression;
use Packaged\QueryBuilder\Expression\CaseExpression;
use Packaged\QueryBuilder\Expression\CounterExpression;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\IExpression;
use Packaged\QueryBuilder\Expression\IfExpression;
use Packaged\QueryBuilder\Expression\NowExpression;
use Packaged\QueryBuilder\Expression\NumericExpression;
use Packaged\QueryBuilder\Expression\StringExpression;
use Packaged\QueryBuilder\Expression\TableExpression;
use Packaged\QueryBuilder\Expression\UnixTimestampExpression;
use Packaged\QueryBuilder\Expression\ValueExpression;

class ExpressionAssembler extends AbstractSegmentAssembler
{
  public function __construct(IExpression $expression)
  {
    $this->_segment = $expression;
  }

  /**
   * Assemble the segment
   *
   * @return string
   */
  public function assemble()
  {
    if($this->_segment instanceof FieldExpression)
    {
      return $this->assembleFieldExpression($this->_segment);
    }
    else if($this->_segment instanceof TableExpression)
    {
      return $this->assembleTableExpression($this->_segment);
    }
    else if($this->_segment instanceof NumericExpression)
    {
      return $this->assembleNumericExpression($this->_segment);
    }
    else if($this->_segment instanceof StringExpression)
    {
      return $this->assembleStringExpression($this->_segment);
    }
    else if($this->_segment instanceof ArrayExpression)
    {
      return $this->assembleArrayExpression($this->_segment);
    }
    else if($this->_segment instanceof ValueExpression)
    {
      return $this->assembleValueExpression($this->_segment);
    }
    else if($this->_segment instanceof CaseExpression)
    {
      return $this->assembleCaseExpression($this->_segment);
    }
    else if($this->_segment instanceof IfExpression)
    {
      return $this->assembleIfExpression($this->_segment);
    }
    else if($this->_segment instanceof AbstractArithmeticExpression)
    {
      return $this->assembleArithmeticExpression($this->_segment);
    }
    else if($this->_segment instanceof CounterExpression)
    {
      return $this->assembleCounterExpression($this->_segment);
    }
    else if($this->_segment instanceof NowExpression)
    {
      return $this->_segment->getFunction();
    }
    else if($this->_segment instanceof UnixTimestampExpression)
    {
      return $this->_segment->getFunction();
    }
    return parent::assemble();
  }

  public function assembleCaseExpression(CaseExpression $expr)
  {
    return 'CASE WHEN(' . $this->assembleSegment($expr->getExpression()) . ')'
    . ' THEN ' . $this->assembleSegment($expr->getTrueValue())
    . ' ELSE ' . $this->assembleSegment($expr->getFalseValue())
    . ' END';
  }

  public function assembleIfExpression(IfExpression $expr)
  {
    $sections = [
      $this->assembleSegment($expr->getExpression()),
      $this->assembleSegment($expr->getTrueValue()),
      $this->assembleSegment($expr->getFalseValue()),
    ];
    return 'IF(' . implode(',', $sections) . ')';
  }

  public function assembleStringExpression(StringExpression $expr)
  {
    return $this->_assemblePrepared()
      ?: $this->escapeValue($expr->getValue());
  }

  public function assembleArrayExpression(ArrayExpression $expr)
  {
    $values = [];
    foreach($expr->getValue() as $value)
    {
      $values[] = $this->_assemblePrepared($value)
        ?: $this->escapeValue($value);
    }
    return '(' . implode(',', $values) . ')';
  }

  public function assembleNumericExpression(NumericExpression $expr)
  {
    return $this->_assemblePrepared() ?: $expr->getValue();
  }

  public function assembleBooleanExpression(BooleanExpression $expr)
  {
    return $this->_assemblePrepared()
      ?: ($expr->getValue() ? 'true' : 'false');
  }

  public function assembleCounterExpression(CounterExpression $expr)
  {
    return $this->assembleSegment($expr->getField())
    . ' ' . $expr->getOperator() . ' '
    . $this->assembleSegment($expr->getValue());
  }

  public function assembleArithmeticExpression(
    AbstractArithmeticExpression $expr
  )
  {
    $values = [];
    foreach($expr->getExpressions() as $value)
    {
      $values[] = $this->assembleSegment($value);
    }
    return '(' . implode(' ' . $expr->getOperator() . ' ', $values) . ')';
  }

  public function assembleValueExpression(ValueExpression $expression)
  {
    $value = $expression->getValue();
    if($value === null)
    {
      return $this->_assemblePrepared() ?: 'NULL';
    }
    else if(is_scalar($value))
    {
      if(is_string($value))
      {
        return $this->assembleStringExpression(
          StringExpression::create($value)
        );
      }
      else if(is_numeric($value))
      {
        return $this->assembleNumericExpression(
          NumericExpression::create($value)
        );
      }
      else if(is_bool($value))
      {
        return $this->assembleBooleanExpression(
          BooleanExpression::create($value)
        );
      }
    }
    else if(is_array($value))
    {
      return $this->assembleArrayExpression(
        ArrayExpression::create($value)
      );
    }
    return $this->assembleStringExpression(
      StringExpression::create($value)
    );
  }

  public function assembleFieldExpression(FieldExpression $expr)
  {
    return ($expr->hasTable() ?
      $this->assembleSegment($expr->getTable()) . '.' : '')
    . $this->escapeField($expr->getField());
  }

  public function assembleTableExpression(TableExpression $expr)
  {
    return $this->escapeField($expr->getTableName());
  }
}
