<?php
namespace Packaged\QueryBuilder\Assembler\Segments;

use Packaged\QueryBuilder\SelectExpression\AllSelectExpression;
use Packaged\QueryBuilder\SelectExpression\ConcatSelectExpression;
use Packaged\QueryBuilder\SelectExpression\CountSelectExpression;
use Packaged\QueryBuilder\SelectExpression\CustomSelectExpression;
use Packaged\QueryBuilder\SelectExpression\ExpressionSelectExpression;
use Packaged\QueryBuilder\SelectExpression\FieldSelectExpression;
use Packaged\QueryBuilder\SelectExpression\FormatSelectExpression;
use Packaged\QueryBuilder\SelectExpression\FunctionSelectExpression;
use Packaged\QueryBuilder\SelectExpression\ISelectExpression;
use Packaged\QueryBuilder\SelectExpression\NowSelectExpression;
use Packaged\QueryBuilder\SelectExpression\ReplaceSelectExpression;
use Packaged\QueryBuilder\SelectExpression\SubQuerySelectExpression;
use Packaged\QueryBuilder\SelectExpression\SubStringSelectExpression;
use Packaged\QueryBuilder\SelectExpression\TableSelectExpression;
use Packaged\QueryBuilder\SelectExpression\TrimSelectExpression;

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
    else if($this->_segment instanceof TrimSelectExpression)
    {
      return $this->assembleTrimSelectExpression($this->_segment);
    }
    else if($this->_segment instanceof ReplaceSelectExpression)
    {
      return $this->assembleReplaceSelectExpression($this->_segment);
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
    else if($this->_segment instanceof CustomSelectExpression)
    {
      return $this->assembleCustomSelect($this->_segment);
    }
    else if($this->_segment instanceof FieldSelectExpression)
    {
      return $this->assembleField($this->_segment);
    }
    else if($this->_segment instanceof TableSelectExpression)
    {
      return $this->assembleTable($this->_segment);
    }
    return parent::assemble();
  }

  public function assembleCustomSelect(CustomSelectExpression $expr)
  {
    return $this->assembleSegment($expr->getField())
    . ($expr->hasAlias() ? ' AS ' . $this->escapeField($expr->getAlias()) : '');
  }

  public function assembleExpressionSelect(ExpressionSelectExpression $expr)
  {
    return $this->assembleSegment($expr->getField())
    . ($expr->hasAlias() ? ' AS ' . $this->escapeField($expr->getAlias()) : '');
  }

  public function assembleNowSelectExpression(NowSelectExpression $expr)
  {
    return $expr->getFunction()
    . ($expr->hasAlias() ? ' AS ' . $this->escapeField($expr->getAlias()) : '');
  }

  public function assembleSubQueryExpression(SubQuerySelectExpression $expr)
  {
    return '(' . $this->assembleSegment($expr->getQuery()) . ')'
    . ($expr->hasAlias() ? ' AS ' . $this->escapeField($expr->getAlias()) : '');
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
    $result = $this->assembleSegment($field->getField());
    if($collation = $field->getCollation())
    {
      $result .= ' COLLATE ' . $collation;
    }
    if($alias = $field->hasAlias())
    {
      $result .= ' AS ' . $this->escapeField($field->getAlias());
    }
    return $result;
  }

  public function assembleTable(TableSelectExpression $field)
  {
    return $this->assembleSegment($field->getTable())
    . ($field->hasAlias()
      ? ' AS ' . $this->escapeField($field->getAlias()) : '');
  }

  public function assembleFunction(FunctionSelectExpression $field)
  {
    return $field->getFunctionName()
    . '('
    . ($field->getField() === null || $field instanceof AllSelectExpression
      ? '*' : $this->getAssembler()->assembleSegment($field->getField()))
    . ')'
    . ($field->hasAlias()
      ? ' AS ' . $this->escapeField($field->getAlias()) : '');
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

  public function assembleTrimSelectExpression(TrimSelectExpression $expr)
  {
    $build = [];
    if($expr->hasSide())
    {
      $build[] = $expr->getSide();
    }
    if($expr->hasString())
    {
      $build[] = $this->getAssembler()->assembleSegment($expr->getString());
    }
    if($expr->hasSide() || $expr->hasString())
    {
      $build[] = 'FROM';
    }
    $build[] = $this->getAssembler()->assembleSegment($expr->getField());

    return sprintf(
      '%s(%s)%s',
      $expr->getFunctionName(),
      implode(' ', $build),
      $expr->hasAlias() ? ' AS ' . $this->escapeField($expr->getAlias()) : ''
    );
  }

  public function assembleReplaceSelectExpression(ReplaceSelectExpression $expr)
  {
    return sprintf(
      '%s(%s,%s,%s)%s',
      $expr->getFunctionName(),
      $this->getAssembler()->assembleSegment($expr->getField()),
      $this->getAssembler()->assembleSegment($expr->getSearchString()),
      $this->getAssembler()->assembleSegment($expr->getReplaceString()),
      $expr->hasAlias() ? ' AS ' . $this->escapeField($expr->getAlias()) : ''
    );
  }
}
