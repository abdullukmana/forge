<?php

namespace Forge\Uiunit\Cells;

use CodeIgniter\View\Cells\Cell;

class NavigationCell extends Cell
{
    public array $items = [];
    public array $colors = [];

    public function mount(): void
    {
        if (empty($this->items)) {
            $this->items = [
                [
                    'title' => 'Belum ada list apapun disini',
                ]
            ];
        }

        if (empty($this->colors)) {
            $this->colors = ['#F5B8BB', '#BDD4FC', '#95D6AD', '#DBA3EA'];
        }
    }
}
