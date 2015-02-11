<?php
namespace Packaged\QueryBuilder\Assembler\Segments;

use Packaged\QueryBuilder\Expression\AbstractArithmeticExpression;
use Packaged\QueryBuilder\Expression\ArrayExpression;
use Packaged\QueryBuilder\Expression\BooleanExpression;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Expression\IExpression;
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
    else if($this->_segment instanceof AbstractArithmeticExpression)
    {
      return $this->assembleArithmeticExpression($this->_segment);
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

  public function assembleArrayExpression(ArrayExpression $expr)
  {
    $values = [];
    foreach($expr->getValue() as $value)
    {
      $values[] = $this->_assemblePrepared(ValueExpression::create($value))
        ?: '"' . $value . '"';
    }
    return '(' . implode(',', $values) . ')';
  }

  public function assembleStringExpression(StringExpression $expr)
  {
    return $this->_assemblePrepared($expr) ?: '"' . $expr->getValue() . '"';
  }

  public function assembleNumericExpression(NumericExpression $expr)
  {
    return $this->_assemblePrepared($expr) ?: $expr->getValue();
  }

  public function assembleBooleanExpression(BooleanExpression $expr)
  {
    return $this->_assemblePrepared($expr->getValue())
      ?: ($expr->getValue() ? 'true' : 'false');
  }

  public function assembleArithmeticExpression(
    AbstractArithmeticExpression $predicate
  )
  {
    return $this->assembleSegment($predicate->getField()) . ' '
    . $predicate->getOperator() . ' '
    . $this->assembleSegment($predicate->getExpression());
  }

  public function assembleValueExpression(ValueExpression $expression)
  {
    $value = $expression->getValue();
    if($value === null)
    {
      return $this->_assemblePrepared($expression) ?: 'NULL';
    }

    if(is_bool($value))
    {
      return $this->assembleBooleanExpression(
        BooleanExpression::create($value)
      );
    }

    if(is_numeric($value))
    {
      return $this->assembleNumericExpression(
        NumericExpression::create($value)
      );
    }

    if(is_array($value))
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
    . $expr->getField();
  }

  public function assembleTableExpression(TableExpression $expr)
  {
    return $expr->getTableName();
  }
}
