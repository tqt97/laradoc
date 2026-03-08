<?php

namespace App\Data;

use Prezet\Prezet\Data\FrontmatterData;
use WendellAdriel\ValidatedDTO\Attributes\Rules;

class CustomFrontmatterData extends FrontmatterData
{
    #[Rules(['nullable', 'integer'])]
    public ?int $order;

    /**
     * Override defaults to include order.
     */
    protected function defaults(): array
    {
        return array_merge(parent::defaults(), [
            'order' => null,
        ]);
    }
}
