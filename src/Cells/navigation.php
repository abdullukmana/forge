<?php

function slugify(string $text): string
{
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text); // Ganti karakter non-alfanumerik
    return trim($text, '-');
}

function flattenHtml(array $nested): array
{
    $flat = [];

    foreach ($nested as $item) {
        if (is_array($item)) {
            $flat = array_merge($flat, flattenHtml($item));
        } else {
            $flat[] = $item;
        }
    }

    return $flat;
}

function renderMenu(array $items, array $colors, int $level = 0, string $defaultColor = "#F5B8BB"): array
{
    $listColor = $items[0]['color'] ?? ($colors[$level] ?? $defaultColor);
    $html = [
        '<ul class="list-group g-3" style="--list-color: ' . $listColor . ';">'
    ];

    foreach ($items as $item) {
        $hasChildren = !empty($item['children']);
        $color = $item['color'] ?? ($colors[$level] ?? $defaultColor);
        $disabled = empty($item['url']);
        $slugTitle = slugify($item['title']) . "-lvl{$level}";

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
                                . ' data-title="' . esc($item['title']) . '"'
                                . ' data-bs-target="#' . $collapseId . '"'
                                . ' aria-expanded="' . ($isOpen ? 'true' : 'false') . '"'
                                . ' aria-controls="' . $collapseId . '">',
                                '<div class="btn icon d-flex align-items-center justify-content-center">',
                                    '<i class="bi bi-chevron-up"></i>',
                                '</div>',
                                esc($item['title']),
                            '</button>',
                        '</h2>',
                        '<div id="' . $collapseId . '" class="accordion-collapse collapse' . ($isOpen ? ' show' : '') . '" data-bs-parent="#' . $accordionId . '">',
                            '<div class="accordion-body">',
                                renderMenu($item['children'], $colors, $level + 1, $defaultColor),
                            '</div>',
                        '</div>',
                    '</div>',
                '</div>',
            ];
        } else {
            if (!$disabled) {
                $isActive = $item['is_active'] ?? false;
                $html[] = [
                    '<a aria-disabled="' . ($isActive ? ' true' : 'false') . '" ' . ($isActive ? ' disabled' : '') . ' style="--list-color: ' . $color . ';" href="' . $item['url'] . '" class="list-group-item list-group-item-action' . ($isActive ? ' active' : '') . '">',
                        '<h6 class="m-0">' . esc($item['title']) . '</h6>',
                    '</a>',
                ];
            } else {
                $html[] = [
                    '<li style="--list-color: ' . $color . ';" class="list-group-item list-group-item-action small">',
                        '<h6 class="m-0">' . esc($item['title']) . '</h6>',
                    '</li>',
                ];
            }
        }
    }

    $html[] = '</ul>';

    return $html;
}
?>
<?php
echo implode("\n", flattenHtml(
    renderMenu($items, $colors)
));
?>
