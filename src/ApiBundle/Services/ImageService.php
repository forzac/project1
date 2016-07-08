<?php
/**
 * Created by PhpStorm.
 * User: hanzera
 * Date: 12/9/15
 * Time: 11:54 AM
 */

namespace ApiBundle\Services;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use StockBundle\Entity\Image;
use Imagick;

class ImageService extends Controller
{
    /**
     * @param null|array $uploadedFile
     * @param null|array $images
     * @return array
     */
    public function upload($uploadedFile = null, $images = null)
    {

        if ($uploadedFile) {
            for ($i = 0; $i < count($uploadedFile); $i++) {
                $picture1 = new Image();
                $imgName = $this->processImage($uploadedFile[$i]);

                $thumb = explode('.', $imgName);
                $thumbname = $thumb[0] . '_thumb.' . $thumb[1];
                $picture1->setPath('/upload/temp/' . $imgName);

                $uploadParameters = ['files' =>[['name' => $this->getOrininalName($uploadedFile[$i]), 'url'=> '/upload/temp/' . $imgName,
                    'thumbnailUrl' => '/upload/temp/' . $thumbname, 'img_name' => $imgName]]];
                return $uploadParameters;
            }

        } elseif ($images) {
            $uploadParameters=['files'=>[]];

            for ($i = 0; $i < count($images); $i++) {
                $path[$i] = $images[$i]->getPath();
                $identificator[$i] = $images[$i]->getId();
                $imageName = str_replace('upload/', '', $path[$i]);
                $thumb = str_replace('.', '_thumb.', $path[$i]);
                array_push($uploadParameters['files'], ['name' => $imageName, 'url'=> '/' . $path[$i], 'thumbnailUrl' => '/' . $thumb,
                    'deleteUrl' => '/api/products/images/' . $identificator[$i],'deleteType' => 'DELETE' ]);

            }
            return $uploadParameters;
        }


    }

    /**
     * Move images from default store file to own store
     *
     * @param UploadedFile $uploadedFile
     * @return string
     */
    public static function processImage(UploadedFile $uploadedFile)
    {
        $path = 'upload/temp/';
        $uploadedFileInfo = pathinfo($uploadedFile->getClientOriginalName());
        $randomname = uniqid();
        $filename =  $randomname . "." . $uploadedFileInfo['extension'];
        $thumbname = $randomname . '_thumb.' . $uploadedFileInfo['extension'];

        $uploadedFile->move($path, $filename);

        copy('upload/temp/' . $filename, 'upload/temp/' . $thumbname);

        $image = new Imagick('upload/temp/' . $thumbname);
        $image->thumbnailImage(120, 0);
        $image->writeImage();

        return $filename;
    }

    /**
     * Get images name before rename
     *
     * @param UploadedFile $uploadedFile
     * @return null|string
     */
    public function getOrininalName(UploadedFile $uploadedFile)
    {
        $origninal = $uploadedFile->getClientOriginalName();

        return $origninal;
    }
}
