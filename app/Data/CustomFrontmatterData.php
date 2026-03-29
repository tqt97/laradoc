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

    #[Rules(['nullable', 'string', 'in:free,pro,premium'])]
    public ?string $type;

    #[Rules(['nullable', 'string', 'in:basic,medium,hard'])]
    public ?string $level;

    #[Rules(['bool'])]
    public bool $locked = false;

    /**
     * Override defaults method
     */
    protected function defaults(): array
    {
        return array_merge(parent::defaults(), [
            'order' => null,
            'idea_id' => null,
            'type' => 'free',
            'level' => null,
            'locked' => false,
        ]);
    }
}
