<?php

namespace Forge\Uiunit\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class UiInit extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Forge';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'ui:init';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Menyalin asset UI awal dari forge/uiinit ke public/.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'ui:init';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $src = ROOTPATH . 'vendor/forge/uiunit/public';
        $dst = ROOTPATH . 'public/';

        if (! is_dir($src)) {
            CLI::error("Folder sumber tidak ditemukan: $src", 'yellow');
            return;
        }

        if ($this->copyFolder($src, $dst)) {
            CLI::write("Asset UI berhasil disalin ke: $dst", 'green');
        } else {
            CLI::error("Gagal menyalin asset.", 'red');
        }
    }

    protected function copyFolder(string $source, string $destination): bool
    {
        if (!is_dir($source)) {
            return false;
        }

        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $items = scandir($source);

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $src = $source . DIRECTORY_SEPARATOR . $item;
            $dst = $destination . DIRECTORY_SEPARATOR . $item;

            if (is_dir($src)) {
                if (! $this->copyFolder($src, $dst)) {
                    return false;
                }
            } else {
                if (!copy($src, $dst)) {
                    return false;
                }
            }
        }

        return true;
    }

}
