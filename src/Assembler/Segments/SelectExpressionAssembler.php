<?php
namespace Packaged\QueryBuilder\Assembler\Segments;

use Packaged\QueryBuilder\SelectExpression\AllSelectExpression;
use Packaged\QueryBuilder\SelectExpression\ConcatSelectExpression;
use Packaged\QueryBuilder\SelectExpression\CountSelectExpression;
use Packaged\QueryBuilder\SelectExpression\ExpressionSelectExpression;
use Packaged\QueryBuilder\SelectExpression\FieldSelectExpression;
use Packaged\QueryBuilder\SelectExpression\FormatSelectExpression;
use Packaged\QueryBuilder\SelectExpression\FunctionSelectExpression;
use Packaged\QueryBuilder\SelectExpression\ISelectExpression;
use Packaged\QueryBuilder\SelectExpression\NowSelectExpression;
use Packaged\QueryBuilder\SelectExpression\SubQuerySelectExpression;
use Packaged\QueryBuilder\SelectExpression\SubStringSelectExpression;

class SelectExpressionAssembler extends AbstractSegmentAssembler
{

  public function __construct(ISelectExpression $expression)
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
    if($this->_segment instanceof AllSelectExpression)
    {
      return $this->assembleAllSelectExpression($this->_segment);
    }
    else if($this->_segment instanceof ConcatSelectExpression)
    {
      return $this->assembleConcatSelectExpression($this->_segment);
    }
    else if($this->_segment instanceof SubQuerySelectExpression)
    {
      return $this->assembleSubQueryExpression($this->_segment);
    }
    else if($this->_segment instanceof NowSelectExpression)
    {
      return $this->assembleNowSelectExpression($this->_segment);
    }
    else if($this->_segment instanceof SubStringSelectExpression)
    {
      return $this->assembleSubStringSelectExpression($this->_segment);
    }
    else if($this->_segment instanceof FormatSelectExpression)
    {
      return $this->assembleFormatSelectExpression($this->_segment);
    }
    else if($this->_segment instanceof CountSelectExpression)
    {
      return $this->assembleCountFunction($this->_segment);
    }
    else if($this->_segment instanceof FunctionSelectExpression)
    {
      return $this->assembleFunction($this->_segment);
    }
    else if($this->_segment instanceof ExpressionSelectExpression)
    {
      return $this->assembleExpressionSelect($this->_segment);
    }
    else if($this->_segment instanceof FieldSelectExpression)
    {
      return $this->assembleField($this->_segment);
    }
    return parent::assemble();
  }

  public function assembleExpressionSelect(ExpressionSelectExpression $expr)
  {
    return $this->assembleSegment($expr->getExpression())
    . ($expr->hasAlias() ? ' AS ' . $this->escapeField($expr->getAlias()) : '');
  }

  public function assembleNowSelectExpression(NowSelectExpression $expr)
  {
    return $expr->getFunction()
    . ($expr->hasAlias() ? ' AS ' . $this->escapeField($expr->getAlias()) : '');
  }

  public function assembleSubQueryExpression(SubQuerySelectExpression $expr)
  {
    return '(' . $this->assembleSegment($expr->getQuery())
    . ') AS ' . $this->escapeField($expr->getAlias());
  }

  public function assembleConcatSelectExpression(ConcatSelectExpression $expr)
  {
    return 'CONCAT('
    . implode(',', $this->assembleSegments($expr->getProperties()))
    . ')'
    . ($expr->hasAlias() ? ' AS ' . $this->escapeField($expr->getAlias()) : '');
  }

  public function assembleAllSelectExpression(AllSelectExpression $expr)
  {
    return $expr->hasTable() ? $this->escapeField(
        $expr->getTable()
      ) . '.*' : '*';
  }

  public function assembleField(FieldSelectExpression $field)
  {
    return $this->assembleSegment($field->getField())
    . ($field->hasAlias() ? ' AS ' . $this->escapeField(
        $field->getAlias()
      ) : '');
  }

  public function assembleFunction(FunctionSelectExpression $field)
  {
    return $field->getFunctionName()
    . '('
    . ($field->getField() === null ?
      '*'
      : $this->getAssembler()->assembleSegment($field->getField()))
    . ')'
    . ($field->hasAlias() ? ' AS ' . $this->escapeField(
        $field->getAlias()
      ) : '');
  }

  public function assembleCountFunction(CountSelectExpression $field)
  {
    return $field->getFunctionName()
    . '('
    . ($field->isDistinct() ? 'DISTINCT ' : '')
    . ($field->getField() === null ?
      '*'
      : $this->getAssembler()->assembleSegment($field->getField()))
    . ')'
    . ($field->hasAlias() ? ' AS ' . $this->escapeField(
        $field->getAlias()
      ) : '');
  }

  public function assembleFormatSelectExpression(FormatSelectExpression $expr)
  {
    return $expr->getFunctionName()
    . '('
    . $this->getAssembler()->assembleSegment($expr->getField())
    . ($expr->hasPrecision() ? ',' . $expr->getPrecision() : '')
    . ')'
    . ($expr->hasAlias() ? ' AS ' . $this->escapeField($expr->getAlias()) : '');
  }

  public function assembleSubStringSelectExpression(
    SubStringSelectExpression $expr
  )
  {
    return $expr->getFunctionName()
    . '('
    . $this->getAssembler()->assembleSegment($expr->getField())
    . ',' . $expr->getStartPosition()
    . ($expr->hasLength() ? ',' . $expr->getLength() : '')
    . ')'
    . ($expr->hasAlias() ? ' AS ' . $this->escapeField($expr->getAlias()) : '');
  }
}
