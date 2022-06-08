<?php

namespace Tests\Fixtures\Models;

use DragonCode\SimpleDataTransferObject\DataTransferObject;

class CommandResult extends DataTransferObject
{
    public array $output;

    public int $code;
}
