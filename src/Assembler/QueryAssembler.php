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
  protected $_parameters = [];
  protected $_namedParameters = [];

  /**
   * @param IStatement $statement
   * @param bool       $forPrepare If the statement should be build with parameters
   */
  public function __construct(IStatement $statement = null, $forPrepare = true)
  {
    $this->_statement  = $statement;
    $this->_forPrepare = $forPrepare;
  }

  public function assemble()
  {
    if($this->_statement === null)
    {
      throw new \Exception("You must construct the assembler with a statement");
    }
    return $this->assembleSegment($this->_statement);
  }

  public function __toString()
  {
    return $this->assemble();
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

  public function getParameters()
  {
    return $this->_parameters;
  }

  public function getNamedParameters()
  {
    return $this->_namedParameters;
  }

  public function addParameter($name, $value)
  {
    $this->_parameters[]           = $value;
    $this->_namedParameters[$name] = $value;
    return $this;
  }

  public static function stringify(IStatementSegment $segment)
  {
    return (new static)->assembleSegment($segment);
  }
}
