<?php
namespace Core;

/**
 * Class PathResolver
 * @package Core
 */
class PathResolver
{
    protected $rootDir;

    public function __construct(string $projectRoot)
    {
        $this->rootDir = $this->getCheckedDirPath($projectRoot);
    }

    public function getRoot(): string {
        return $this->rootDir;
    }

    public function isRelativePath(string $path): bool {
        return strpos($path, '/') === 0 ? false : true;
    }

    public function getCheckedFilePath(string $path): string {
        return $this->getCheckedPath($path, true);
    }

    public function getCheckedDirPath($path): string {
        return $this->getCheckedPath($path);
    }

    protected function getCheckedPath(string $path, bool $isFile = false): string {
        if($path === '') {
            throw new \ErrorException(
                'Путь не может быть пустой строкой.'
            );
        }
        if($this->isRelativePath($path)) {
            $path = $this->rootDir .  '/' . $path;
        }
        $chk = $isFile ? 'is_file' : 'is_dir';
        $name = $isFile ? 'file' : 'directory';
        if(!$chk($path)) {
            throw new \ErrorException(
                'Не могу найти ' . $name . ' по этому пути ' . $path
            );
        }
        return $path;
    }
}