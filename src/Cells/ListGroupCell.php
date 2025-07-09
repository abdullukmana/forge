<?php

namespace Forge\Uiunit\Cells;

use CodeIgniter\View\Cells\Cell;

class ListGroupCell extends Cell
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

    private function slugify(string $text): string
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }

    private function flattenHtml(array $nested): array
    {
        $flat = [];

        foreach ($nested as $item) {
            if (is_array($item)) {
                $flat = array_merge($flat, $this->flattenHtml($item));
            } else {
                $flat[] = $item;
            }
        }

        return $flat;
    }

    private function renderMenu(array $items, array $colors, int $level = 0, string $defaultColor = "#F5B8BB"): array
    {
        $listColor = $items[0]['color'] ?? ($colors[$level] ?? $defaultColor);
        $html = [
            '<ul class="list-group g-3" style="--list-color: ' . $listColor . ';">'
        ];

        foreach ($items as $item) {
            $hasChildren = !empty($item['children']);
            $color = $item['color'] ?? ($colors[$level] ?? $defaultColor);
            $disabled = empty($item['url']);

            $title = is_array($item['title']) ? ($item['title']['name'] ?? 'untitled') : $item['title'];
            $slugTitle = $this->slugify($title) . "-lvl{$level}";

            if ($hasChildren) {
                $isOpen = $item['is_open'] ?? false;
                $accordionId = "accordion-" . $slugTitle;
                $collapseId = "collapse-" . $slugTitle;

                $html[] = [
                    '<div class="accordion" id="' . $accordionId . '">',
                        '<div style="--list-color: ' . $color . ';" class="accordion-item">',
                            '<h2 class="accordion-header">',
                                '<button class="accordion-button ' . ($isOpen ? '' : 'collapsed') . '" type="button"'
                                    . ' data-bs-toggle="collapse"'
                                    . ' data-title="' . esc($title) . '"'
                                    . ' data-bs-target="#' . $collapseId . '"'
                                    . ' aria-expanded="' . ($isOpen ? 'true' : 'false') . '"'
                                    . ' aria-controls="' . $collapseId . '">',
                                    '<div class="btn icon d-flex align-items-center justify-content-center">',
                                        '<i class="bi bi-chevron-up"></i>',
                                    '</div>',
                                    esc($title),
                                '</button>',
                            '</h2>',
                            '<div id="' . $collapseId . '" class="accordion-collapse collapse' . ($isOpen ? ' show' : '') . '" data-bs-parent="#' . $accordionId . '">',
                                '<div class="accordion-body">',
                                    $this->renderMenu($item['children'], $colors, $level + 1, $defaultColor),
                                '</div>',
                            '</div>',
                        '</div>',
                    '</div>',
                ];
            } else {
                if (!$disabled) {
                    $isActive = $item['is_active'] ?? false;
                    $html[] = [
                        '<a aria-disabled="' . ($isActive ? 'true' : 'false') . '" ' . ($isActive ? ' disabled' : '') . ' style="--list-color: ' . $color . ';" href="' . $item['url'] . '" class="list-group-item list-group-item-action' . ($isActive ? ' active' : '') . '">',
                            '<h6 class="m-0">' . esc($title) . '</h6>',
                        '</a>',
                    ];
                } else {
                    $html[] = [
                        '<li style="--list-color: ' . $color . ';" class="list-group-item list-group-item-action small">',
                            '<h6 class="m-0">' . esc($title) . '</h6>',
                        '</li>',
                    ];
                }
            }
        }

        $html[] = '</ul>';

        return $html;
    }

    public function render(): string
    {
        return implode("\n", $this->flattenHtml(
            $this->renderMenu($this->items, $this->colors)
        ));
    }

}
