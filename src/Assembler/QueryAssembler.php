<?php
namespace Packaged\QueryBuilder\Assembler;

use Packaged\QueryBuilder\Assembler\Segments\AbstractSegmentAssembler;
use Packaged\QueryBuilder\Assembler\Segments\ClauseAssembler;
use Packaged\QueryBuilder\Assembler\Segments\ExpressionAssembler;
use Packaged\QueryBuilder\Assembler\Segments\PredicateAssembler;
use Packaged\QueryBuilder\Assembler\Segments\SelectExpressionAssembler;
use Packaged\QueryBuilder\Assembler\Segments\StatementAssembler;
use Packaged\QueryBuilder\Clause\IClause;
use Packaged\QueryBuilder\Expression\IExpression;
use Packaged\QueryBuilder\Expression\ValueExpression;
use Packaged\QueryBuilder\Predicate\IPredicate;
use Packaged\QueryBuilder\SelectExpression\ISelectExpression;
use Packaged\QueryBuilder\Statement\IStatement;
use Packaged\QueryBuilder\Statement\IStatementSegment;

class QueryAssembler
{
  /**
   * @var IStatement
   */
  protected $_statement;
  protected $_forPrepare = true;
  protected $_parameters;
  protected $_query;
  protected $_data;

  /**
   * @param IStatement $statement
   * @param bool       $forPrepare If the statement should be build with parameters
   */
  public function __construct(IStatement $statement = null, $forPrepare = true)
  {
    $this->_statement = $statement;
    $this->_forPrepare = $forPrepare;
    if($statement)
    {
      $this->assemble();
    }
  }

  public function getData($key)
  {
    if(isset($this->_data[$key]))
    {
      return $this->_data[$key];
    }
    return null;
  }

  public function setData($key, $data)
  {
    $this->_data[$key] = $data;
  }

  public function assemble($reassemble = false)
  {
    if($reassemble || (!$this->_query))
    {
      $this->_query = '';
      $this->_parameters = [];
      if($this->_statement === null)
      {
        throw new \Exception(
          "You must construct the assembler with a statement"
        );
      }
      $this->_query = $this->assembleSegment($this->_statement);
    }
    return $this;
  }

  public function __toString()
  {
    return $this->assemble()->_query;
  }

  public function assembleSegment($segment)
  {
    $assembler = null;
    if(is_scalar($segment))
    {
      return $segment;
    }
    else if($segment instanceof IStatement)
    {
      $assembler = new StatementAssembler($segment);
    }
    else if($segment instanceof IClause)
    {
      $assembler = new ClauseAssembler($segment);
    }
    else if($segment instanceof IPredicate)
    {
      $assembler = new PredicateAssembler($segment);
    }
    else if($segment instanceof ISelectExpression)
    {
      $assembler = new SelectExpressionAssembler($segment);
    }
    else if($segment instanceof IExpression)
    {
      $assembler = new ExpressionAssembler($segment);
    }

    if($assembler !== null && $assembler instanceof AbstractSegmentAssembler)
    {
      $assembler->setAssembler($this);
      return $assembler->assemble();
    }
    throw new \Exception("Unsupported segment type " . get_class($segment));
  }

  public function assembleSegments($segments)
  {
    return array_map([$this, 'assembleSegment'], $segments);
  }

  public function isForPrepare()
  {
    return $this->_forPrepare;
  }

  public function addParameter($value)
  {
    if($value instanceof ValueExpression)
    {
      $value = $value->getValue();
    }
    $this->_parameters[] = $value;
    return $this;
  }

  public function getParameters()
  {
    return $this->_parameters;
  }

  public function getQuery()
  {
    return $this->_query;
  }

  public static function stringify(IStatementSegment $segment)
  {
    return (new static(null, false))->assembleSegment($segment);
  }
}
