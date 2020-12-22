<?php

namespace Chemem\Bingo\Functional\Tests\Immutable;

\error_reporting(0);

use \Eris\Generator;

use Chemem\Bingo\Functional\Algorithms as f;
use Chemem\Bingo\Functional\Immutable\Collection;
use function Chemem\Bingo\Functional\Tests\functorLaws;

class CollectionTest extends \PHPUnit\Framework\TestCase
{
  use \Eris\TestTrait;

  /**
   * @test
   */
  public function CollectionObeysFunctorLaws()
  {
    $this
      ->forAll(
        Generator\tuple(
          Generator\int(),
          Generator\int(),
          Generator\float()
        )
      )
      ->then(function ($list) {
        $immlist  = Collection::from($list);
        $fnx      = f\partial('pow', 2);
        $fny      = function ($val) {
          return $val + 10;
        };

        $this->assertEquals([
          'identity'    => true,
          'composition' => true,
        ], functorLaws($immlist, $fnx, $fny));
      });
  }

  /**
   * @test
   */
  public function mapTransformsEveryValueInCollection()
  {
    $this
      ->forAll(
          Generator\tuple(
            Generator\names(),
            Generator\string()
        )
      )
      ->then(function ($list) {
        $lst = Collection::from($list)->map('strtoupper');

        $this->assertInstanceOf(Collection::class, $lst);
        $this->assertEquals(f\map('strtoupper', $list), $lst->toArray());
        $this->assertEquals(\count($list), $lst->getSize());
      });
  }

  /**
   * @test
   */
  public function flatMapWorksLikeMapButReturnsArray()
  {
    $this
      ->forAll(
          Generator\tuple(
            Generator\names(),
            Generator\string()
        )
      )
      ->then(function ($list) {
        $lst = Collection::from($list)->flatMap('strtoupper');

        $this->assertIsArray($lst);
        $this->assertEquals(f\map('strtoupper', $list), $lst);
        $this->assertEquals(\count($list), \count($lst));
      });
  }

  /**
   * @test
   */
  public function filterRemovesElementsThatConformToBooleanPredicate()
  {
    $this
      ->forAll(
          Generator\tuple(
            Generator\names(),
            Generator\string()
        )
      )
      ->then(function ($list) {
        $lst = Collection::from($list)->filter('is_string');

        $this->assertInstanceOf(Collection::class, $lst);
        $this->assertEquals(f\filter('is_string', $list), $lst->toArray());
      });
  }
  
  /**
   * @test
   */
  public function rejectRemovesElementsThatConformToBooleanPredicate()
  {
    $this
      ->forAll(
          Generator\tuple(
            Generator\names(),
            Generator\string()
        )
      )
      ->then(function ($list) {
        $lst = Collection::from($list)->reject('is_string');

        $this->assertInstanceOf(Collection::class, $lst);
        $this->assertEquals(f\reject('is_string', $list), $lst->toArray());
      });
  }

  /**
   * @test
   */
  public function anyChecksIfAnyElementInCollectionConformsToBooleanPredicate()
  {
    $this
      ->forAll(
          Generator\tuple(
            Generator\names(),
            Generator\string()
        )
      )
      ->then(function ($list) {
        $any = Collection::from($list)->any('is_string');

        $this->assertIsBool($any);
      });
  }

  /**
   * @test
   */
  public function everyChecksIfEachElementInCollectionConformsToBooleanPredicate()
  {
    $this
      ->forAll(
          Generator\tuple(
            Generator\names(),
            Generator\string()
        )
      )
      ->then(function ($list) {
        $every = Collection::from($list)->every('is_string');

        $this->assertIsBool($every);
      });
  }

  /**
   * @test
   */
  public function foldTransformsCollectionIntoSingleValue()
  {
    $this
      ->forAll(
          Generator\tuple(
            Generator\names(),
            Generator\names(),
            Generator\names()
        ),
          Generator\constant('')
      )
      ->then(function ($list, $acc) {
        $names = Collection::from($list)
          ->fold(function ($acc, $name) {
            $acc .= f\concat(', ', $name, '');

            return $acc;
          }, $acc);

        $this->assertTrue(\gettype($names) == \gettype($acc));
      });
  }

  /**
   * @test
   */
  public function mergeConcatenatesTwoCollections()
  {
    $this
      ->forAll(
          Generator\tuple(
            Generator\names(),
            Generator\int()
        ),
          Generator\tuple(
            Generator\float(),
            Generator\string()
        )
      )
      ->then(function ($fst, $snd) {
        $lst = Collection::from($fst)->merge(Collection::from($snd));

        $this->assertInstanceOf(Collection::class, $lst);
        $this->assertEquals(4, $lst->count());
        $this->assertEquals(f\extend($fst, $snd), $lst->toArray());
      });
  }

  /**
   * @test
   */
  public function mergeNConcatenatesMultipleCollections()
  {
    $this
      ->forAll(
          Generator\tuple(
            Generator\names(),
            Generator\int()
        ),
          Generator\tuple(
            Generator\float()
        ),
          Generator\tuple(
            Generator\string()
        )
      )
      ->then(function ($fst, $snd, $thd) {
        $lst = Collection::from($fst)
          ->mergeN(Collection::from($snd), Collection::from($thd));

        $this->assertInstanceOf(Collection::class, $lst);
        $this->assertEquals(4, $lst->getSize());
        $this->assertEquals(f\extend($fst, $snd, $thd), $lst->toArray());
      });
  }

  /**
   * @test
   */
  public function sliceRemovesElementsFromTheFrontOfCollection()
  {
    $this
      ->forAll(
          Generator\tuple(
            Generator\string(),
            Generator\int(),
            Generator\float()
        )
      )
      ->then(function ($list) {
        $lst = Collection::from($list)->slice(1);

        $this->assertEquals(2, $lst->count());
        $this->assertInstanceOf(Collection::class, $lst);
        $this->assertEquals(\array_slice($list, 1), $lst->toArray());
      });
  }

  /**
   * @test
   */
  public function reversePerformsListOrderReversal()
  {
    $this
      ->forAll(
          Generator\tuple(
            Generator\string(),
            Generator\int(),
            Generator\float()
        )
      )
      ->then(function ($list) {
        $lst = Collection::from($list)->reverse();

        $this->assertEquals(3, $lst->getSize());
        $this->assertEquals(\array_reverse($list), $lst->toArray());
      });
  }

  /**
   * @test
   */
  public function fillOutputsCollectionWithArbitraryValuesAffixedToDefinedIndexes()
  {
    $this
      ->forAll(
          Generator\tuple(
            Generator\int(),
            Generator\float(),
            Generator\string()
        ),
          Generator\constant('foo')
      )
      ->then(function ($list, $const) {
        $lst = Collection::from($list)->fill($const, 1, 2);

        $this->assertEquals(3, $lst->getSize());
        $this->assertInstanceOf(Collection::class, $lst);
        $this->assertEquals(
              f\extend([f\head($list)], [$const], [$const]),
              $lst->toArray()
          );
      });
  }

  /**
   * @test
   */
  public function fetchOutputsKeyGroupedDataInCollection()
  {
    $this
      ->forAll(
          Generator\tuple(
            Generator\associative([
            'num'   => Generator\constant(35),
            'name'  => Generator\constant('Durant'),
          ]),
            Generator\associative([
            'num'   => Generator\constant(6),
            'name'  => Generator\constant('LeBron'),
          ])
        ),
          Generator\elements('num', 'name')
      )
      ->then(function ($list, $key) {
        $lst = Collection::from($list)->fetch($key);

        $this->assertInstanceOf(Collection::class, $lst);
        $this->assertTrue(
              $lst->toArray() == [35, 6] ||
          $lst->toArray() == ['Durant', 'LeBron']
          );
      });
  }

  /**
   * @test
   */
  public function containsChecksIfValueExistsInCollection()
  {
    $this
      ->forAll(
          Generator\tuple(
            Generator\constant('lib'),
            Generator\int(),
            Generator\names()
        )
      )
      ->then(function ($list) {
        $lst = Collection::from($list);

        $this->assertIsBool($lst->contains('lib'));
        $this->assertIsBool($lst->contains('bingo_functional'));
      });
  }

  /**
   * @test
   */
  public function uniqueOutputsCollectionWithoutDuplicateEntries()
  {
    $this
      ->forAll(
          Generator\tuple(
            Generator\constant('foo'),
            Generator\constant('foo'),
            Generator\float()
        )
      )
      ->then(function ($list) {
        $lst = Collection::from($list)->unique();

        $this->assertInstanceOf(Collection::class, $lst);
        $this->assertEquals(\array_values(f\unique($list)), $lst->toArray());
      });
  }

  /**
   * @test
   */
  public function implodeJoinsCollectionElementsWithString()
  {
    $this
      ->forAll(
          Generator\tuple(
            Generator\constant('foo'),
            Generator\constant('bar'),
            Generator\constant('baz')
        )
      )
      ->then(function ($list) {
        $str = Collection::from($list)->implode(':');

        $this->assertIsString($str);
        $this->assertEquals('foo:bar:baz', $str);
      });
  }

  /**
   * @test
   */
  public function headOutputsFirstElementInCollection()
  {
    $this
      ->forAll(
          Generator\tuple(
            Generator\constant('foo'),
            Generator\int()
        )
      )
      ->then(function ($list) {
        $fst = Collection::from($list)->head();

        $this->assertEquals('foo', $fst);
      });
  }

  /**
   * @test
   */
  public function lastOutputsLastElementInCollection()
  {
    $this
      ->forAll(
          Generator\tuple(
            Generator\int(),
            Generator\constant('foo')
        )
      )
      ->then(function ($list) {
        $lst = Collection::from($list)->last();

        $this->assertEquals('foo', $lst);
      });
  }

  /**
   * @test
   */
  public function tailOutputsAllCollectionElementsButTheFirst()
  {
    $this
      ->forAll(
          Generator\tuple(
            Generator\int(),
            Generator\string(),
            Generator\float()
        )
      )
      ->then(function ($list) {
        $lst = Collection::from($list)->tail();

        $this->assertInstanceOf(Collection::class, $lst);
        $this->assertEquals(2, \count($lst));
        $this->assertEquals(\array_values(f\tail($list)), $lst->toArray());
      });
  }

  /**
   * @test
   */
  public function intersectsChecksIfTwoCollectionsIntersect()
  {
    $this
      ->forAll(
          Generator\tuple(
            Generator\int(),
            Generator\names()
        ),
          Generator\tuple(
            Generator\string(),
            Generator\int()
        )
      )
      ->then(function ($fst, $snd) {
        $intersects = Collection::from($fst)
          ->intersects(Collection::from($snd));

        $this->assertIsBool($intersects);
      });
  }
}
