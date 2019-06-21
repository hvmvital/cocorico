<?php

/*
 * This file is part of the Cocorico package.
 *
 * (c) Cocolabs SAS <contact@cocolabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocorico\CoreBundle\Namer;


use Oneup\UploaderBundle\Uploader\File\FileInterface;
use Oneup\UploaderBundle\Uploader\Naming\NamerInterface;
use Symfony\Component\HttpFoundation\Session\Session;


/**
 * FileNamer
 *
 */
class FileNamer implements NamerInterface
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }


    /**
     * @param  FileInterface $file
     * @return string
     */

    public function name0(FileInterface $file)
    {

        $name = "";
        if ($extension = $file->getExtension()) {
            $name = sprintf($file->getClientOriginalName());
        }

        return $name;
    }


    public function name(FileInterface $file)
    {
        $file_directory = $this->session->get('file_directory');
        $unique_name = uniqid();

        return sprintf('%s/%s_%s',
            $file_directory,
            $unique_name,
            $file->getClientOriginalName()
        );
    }



}
