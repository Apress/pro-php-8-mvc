<?php

namespace Framework\Database\Migration\Field;

use Framework\Database\Exception\MigrationException;

class IdField extends Field
{
    public function default()
    {
        throw new MigrationException('ID fields cannot have a default value');
    }
}
