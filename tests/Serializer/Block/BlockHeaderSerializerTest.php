<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests\Serializer\Block;

use BitWasp\Bitcoin\Serializer\Block\BlockHeaderSerializer;
use BitWasp\Bitcoin\Tests\AbstractTestCase;
use BitWasp\Buffertools\Buffer;

class BlockHeaderSerializerTest extends AbstractTestCase
{
    /**
     */
    public function testInvalidParse()
    {
        $this->expectException(\BitWasp\Buffertools\Exceptions\ParserOutOfRange::class);

        $serializer = new BlockHeaderSerializer;
        $serializer->parse(new Buffer());
    }
}
