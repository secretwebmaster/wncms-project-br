<?php

namespace App\Services\Managers;

class GameLogRenderManager
{
    public function render(string $content, array $data, ?int $viewerId = null): string
    {
        // 你現有的 keyword parser 放這裡
        // 只在這一層處理「你 / 我 / 他」

        return app('keyword.parser')->parse($content, $data, $viewerId);
    }
}
