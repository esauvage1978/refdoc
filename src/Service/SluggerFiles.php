<?php

namespace App\Service;

use App\Helper\Slugger;
use App\Helper\SplitNameOfFile;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

/**
 * @author Emmanuel SAUVAGE <emmanuel.sauvage@live.fr>
 * @version 1.0.0
 */
class SluggerFiles
{

    /**
     * Slugify files of path
     *
     * @param string $path
     * @return void
     */
    public static function SlugifyFiles(string $path)
    {
        $dir = opendir($path);

        while ($file = readdir($dir)) {

            if (is_file($path . DIRECTORY_SEPARATOR . $file)) {
                $sf= new SplitNameOfFile($file);

                $nameSlugified = Slugger::slugify($sf->getName());
                $extensionSlugified = Slugger::slugify($sf->getExtension());

                $slugifiedFile= $nameSlugified . '.' . $extensionSlugified;

                if ($file != $slugifiedFile) {
                    rename(
                        $path . DIRECTORY_SEPARATOR . $file,
                        $path . DIRECTORY_SEPARATOR . $slugifiedFile
                    );
                }
            }
        }
    }
}
