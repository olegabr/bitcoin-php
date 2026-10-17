<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests\Mnemonic\Bip39\WordList;

use BitWasp\Bitcoin\Tests\AbstractTestCase;

class JapaneseWordListTest extends AbstractTestCase
{
    public function testGetWordList()
    {
        $wl = new \BitWasp\Bitcoin\Mnemonic\Bip39\Wordlist\JapaneseWordList();
        $this->assertEquals(2048, count($wl));
        $this->assertEquals(2048, count($wl->getWords()));
    }

    /**
     */
    public function testUnknownWord()
    {
        $this->expectException(\InvalidArgumentException::class);

        $wl = new \BitWasp\Bitcoin\Mnemonic\Bip39\Wordlist\JapaneseWordList();
        $wl->getWord(101010101);
    }

    /**
     */
    public function testExceptionOutOfRange()
    {
        $this->expectException(\InvalidArgumentException::class);

        $wl = new \BitWasp\Bitcoin\Mnemonic\Bip39\Wordlist\JapaneseWordList();

        $word = $wl->getIndex('あいだ');
        $this->assertIsInt($word);

        $wl->getIndex('あいあいあい');
    }
}
