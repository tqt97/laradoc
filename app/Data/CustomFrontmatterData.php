<?php

namespace App\Data;

use Prezet\Prezet\Data\FrontmatterData;
use WendellAdriel\ValidatedDTO\Attributes\Rules;

class CustomFrontmatterData extends FrontmatterData
{
    #[Rules(['nullable', 'integer'])]
    public ?int $order;

    #[Rules(['nullable', 'integer'])]
    public ?int $idea_id;

    /**
     * Override defaults to include order and idea_id.
     */
    protected function defaults(): array
    {
        return array_merge(parent::defaults(), [
            'order' => null,
            'idea_id' => null,
        ]);
    }
}
