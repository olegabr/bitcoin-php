<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests\Transaction\Mutator;

use BitWasp\Bitcoin\Script\Script;
use BitWasp\Bitcoin\Tests\AbstractTestCase;
use BitWasp\Bitcoin\Transaction\Mutator\InputCollectionMutator;
use BitWasp\Bitcoin\Transaction\Mutator\OutputCollectionMutator;
use BitWasp\Bitcoin\Transaction\OutPoint;
use BitWasp\Bitcoin\Transaction\TransactionInput;
use BitWasp\Bitcoin\Transaction\TransactionOutput;
use BitWasp\Buffertools\Buffer;

/**
 * Regression tests for the collection mutators' Iterator implementation.
 *
 * SplFixedArray stopped implementing \Iterator in PHP 8.0 (it is an
 * IteratorAggregate now, and rewind()/current()/key()/next()/valid() were
 * removed), so AbstractCollectionMutator must keep the iteration state itself.
 * Without that, signing a transaction dies with
 * "Call to undefined method SplFixedArray::rewind()".
 */
class CollectionMutatorIteratorTest extends AbstractTestCase
{
    /**
     * @return TransactionInput[]
     */
    private function inputs(int $count): array
    {
        $inputs = [];
        for ($i = 0; $i < $count; $i++) {
            $txid = Buffer::hex(str_repeat(sprintf('%02x', $i + 1), 32));
            $inputs[] = new TransactionInput(new OutPoint($txid, $i), new Script());
        }

        return $inputs;
    }

    /**
     * @return TransactionOutput[]
     */
    private function outputs(int $count): array
    {
        $outputs = [];
        for ($i = 0; $i < $count; $i++) {
            $outputs[] = new TransactionOutput($i + 1, new Script());
        }

        return $outputs;
    }

    public function testInputCollectionIsIterable()
    {
        $inputs = $this->inputs(3);
        $mutator = new InputCollectionMutator($inputs);

        $seen = [];
        foreach ($mutator as $key => $input) {
            $seen[$key] = $input;
        }

        $this->assertSame([0, 1, 2], array_keys($seen));
        $this->assertCount(3, $seen);
        $this->assertSame($mutator->done(), array_map(function ($input) {
            return $input->done();
        }, $seen));

        // A second foreach must start from the beginning again (rewind()).
        $second = [];
        foreach ($mutator as $key => $input) {
            $second[$key] = $input;
        }
        $this->assertSame(array_keys($seen), array_keys($second));
    }

    public function testOutputCollectionIsIterable()
    {
        $mutator = new OutputCollectionMutator($this->outputs(4));

        $values = [];
        foreach ($mutator as $output) {
            $values[] = $output->done()->getValue();
        }

        $this->assertSame([1, 2, 3, 4], $values);
    }

    public function testIteratorContractIsImplementedWithoutSplFixedArray()
    {
        $mutator = new InputCollectionMutator($this->inputs(2));

        $mutator->rewind();
        $this->assertTrue($mutator->valid());
        $this->assertSame(0, $mutator->key());
        $this->assertSame($mutator[0], $mutator->current());

        $mutator->next();
        $this->assertTrue($mutator->valid());
        $this->assertSame(1, $mutator->key());
        $this->assertSame($mutator[1], $mutator->current());

        $mutator->next();
        $this->assertFalse($mutator->valid());
    }

    public function testEmptyCollectionIsNotIterated()
    {
        $mutator = new InputCollectionMutator([]);

        $mutator->rewind();
        $this->assertFalse($mutator->valid());
        $this->assertCount(0, iterator_to_array($mutator));
        $this->assertCount(0, $mutator);
        $this->assertSame([], $mutator->all());
    }

    public function testIterationFollowsCollectionChanges()
    {
        $mutator = new OutputCollectionMutator($this->outputs(2));
        $this->assertCount(2, iterator_to_array($mutator));

        $mutator->add(new TransactionOutput(99, new Script()));
        $this->assertCount(3, iterator_to_array($mutator));

        $mutator->slice(0, 2);
        $mutator->rewind();
        $this->assertCount(2, iterator_to_array($mutator));
        $this->assertFalse($mutator->valid() && $mutator->key() > 1);
    }

    public function testArrayAccessMatchesTheCollection()
    {
        $mutator = new OutputCollectionMutator($this->outputs(3));

        $this->assertCount(3, $mutator);
        $this->assertTrue(isset($mutator[0]));
        $this->assertFalse(isset($mutator[3]));
        $this->assertFalse($mutator->isNull());
        $this->assertSame([1, 2, 3], array_map(function ($output) {
            return $output->done()->getValue();
        }, $mutator->all()));

        $replacement = $mutator[2];
        $mutator[0] = $replacement;
        $this->assertSame($replacement, $mutator[0]);
        $this->assertSame(3, $mutator->done()[0]->getValue());

        unset($mutator[0]);
        $this->assertFalse(isset($mutator[0]));
    }

    public function testUnsettingAMissingOffsetIsRejected()
    {
        $mutator = new OutputCollectionMutator($this->outputs(1));

        $this->expectException(\InvalidArgumentException::class);
        unset($mutator[5]);
    }
}
