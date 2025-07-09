<?php

namespace Forge\Uiunit\Controllers;

use App\Controllers\BaseController;

class AccordionState extends BaseController
{
    protected string $cookieName = 'opened_accordions';
    protected string $cookieExpireUnit = 'week';
    protected int $cookieExpireAmount = 1;

    protected function getCookieExpireTime(): int
    {
        return match (strtolower($this->cookieExpireUnit)) {
            'day', 'days'     => 60 * 60 * 24 * $this->cookieExpireAmount,
            'week', 'weeks'   => 60 * 60 * 24 * 7 * $this->cookieExpireAmount,
            'month', 'months' => 60 * 60 * 24 * 30 * $this->cookieExpireAmount,
            'year', 'years'   => 60 * 60 * 24 * 365 * $this->cookieExpireAmount,
            default           => 60 * 60 * 24 * 7,
        };
    }

    public function save(string $id)
    {
        $request = service('request');
        $cookieValue = $request->getCookie($this->cookieName);
        $data = json_decode($cookieValue, true) ?? [];

        $currentState = $data[$id]['is_open'] ?? false;
        $newState = !$currentState;

        $data[$id] = ['is_open' => $newState];

        service('response')->setCookie([
            'name'     => $this->cookieName,
            'value'    => json_encode($data),
            'expire'   => $this->getCookieExpireTime(),
            'path'     => '/',
            'httponly' => false,
        ]);

        return $this->response->setJSON([
            'status'  => 'toggled',
            'id'      => $id,
            'is_open' => $newState
        ]);
    }

    public function get()
    {
        $cookieValue = service('request')->getCookie($this->cookieName);
        $data = json_decode($cookieValue, true) ?? [];

        return $data;
    }

    public function clear()
    {
        service('response')->setCookie([
            'name'     => $this->cookieName,
            'value'    => '',
            'expire'   => time() - 3600,
            'path'     => '/',
            'httponly' => false,
        ]);
    }

    public function apply(array &$items): void
    {
        $accordionState = $this->get();
        foreach ($items as &$item) {
            if (isset($accordionState[$item['title']]['is_open'])) {
                $item['is_open'] = $accordionState[$item['title']]['is_open'];
            }

            if (!empty($item['children'])) {
                $this->apply($item['children'], $accordionState);
            }
        }
    }
}
