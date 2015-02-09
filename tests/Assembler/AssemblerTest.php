<?php
namespace Packaged\Tests\QueryBuilder\Assembler;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Builder\QueryBuilder;
use Packaged\QueryBuilder\Clause\IClause;
use Packaged\QueryBuilder\Clause\SelectClause;
use Packaged\QueryBuilder\Expression\TableExpression;
use Packaged\QueryBuilder\Predicate\BetweenPredicate;
use Packaged\QueryBuilder\Predicate\EqualPredicate;
use Packaged\QueryBuilder\Predicate\NotEqualPredicate;
use Packaged\QueryBuilder\Statement\IStatement;
use Packaged\QueryBuilder\Statement\QueryStatement;

class AssemblerTest extends \PHPUnit_Framework_TestCase
{
  /**
   * @expectedException \Exception
   * @expectedExceptionMessage You must construct the assembler with a statement
   */
  public function testAssemblerNoStatement()
  {
    $assembler = new QueryAssembler();
    $this->assertTrue($assembler->isForPrepare());
    $assembler->assemble();
  }

  public function testAssemblerPrepare()
  {
    $stm = new QueryStatement();
    $stm->addClause(new SelectClause())->from('mytable');
    $stm->where(EqualPredicate::create('field1', 'value1'));

    $assembler = new QueryAssembler($stm, false);
    $this->assertEmpty($assembler->getParameters());
    $this->assertFalse($assembler->isForPrepare());
    $this->assertEquals(
      'SELECT * FROM mytable WHERE field1 = "value1"',
      (string)$assembler
    );

    $stm->andWhere(
      [
        'AND' => [
          EqualPredicate::create('field2', null),
          NotEqualPredicate::create('field3', null)
        ],
        'OR'  => BetweenPredicate::create('field4', 123, 456)
      ]
    );
    $assembler = new QueryAssembler($stm, true);
    $this->assertNotEmpty($assembler->getParameters());
    $this->assertTrue($assembler->isForPrepare());
    $this->assertEquals(
      'SELECT * FROM mytable WHERE field1 = ? AND ((field2 IS NULL AND field3 IS NOT NULL) AND field4 BETWEEN ? AND ?)',
      (string)$assembler
    );
    $this->assertEquals(['value1', 123, 456], $assembler->getParameters());
  }

  /**
   * @expectedException \Exception
   * @expectedExceptionMessage Unsupported segment type stdClass
   */
  public function testUnknownStatement()
  {
    $assembler = new QueryAssembler(new UnknownStatement());
    $assembler->assemble();
  }

  public function testParameters()
  {
    $assembler = new QueryAssembler();
    $assembler->addParameter('value');
    $assembler->addParameter('value2');

    $result = ['value', 'value2'];
    $this->assertEquals($result, $assembler->getParameters());
  }

  public function testAssembler()
  {
    $assembler = new QueryAssembler(
      QueryBuilder::insert(TableExpression::create('tbl'), 'field')
        ->values('value')
    );
    $this->assertEquals(
      'INSERT INTO tbl (field) VALUES (?)',
      $assembler->getQuery()
    );
  }
}

class UnknownStatement implements IStatement
{
  public function addClause(IClause $clause)
  {
  }

  public function getClause($action)
  {
  }

  public function hasClause($action)
  {
  }

  public function removeClause($action)
  {
  }

  public function getSegments()
  {
    return [new \stdClass()];
  }
}
