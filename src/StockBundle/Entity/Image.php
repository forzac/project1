<?php
/**
 * Created by PhpStorm.
 * User: hanzera
 * Date: 11/19/15
 * Time: 12:40 PM
 */

namespace StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use StockBundle\Entity\Product;

/**
 * Class Product
 * @package StockBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="images")
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", fetch="LAZY")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $media;

    /**
     * @var \StockBundle\Entity\Product
     * @ORM\ManyToOne(targetEntity="Product",inversedBy="images",cascade={"persist"}, fetch="LAZY" )
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id",nullable=true, onDelete="CASCADE")
     */
    protected $product;

    /**
     * {@inheritdoc}
     */
    public function setProduct(Product $product = null)
    {
        $this->product = $product;
    }

    /**
     * {@inheritdoc}
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * {@inheritdoc}
     */
    public function setMedia(\Sonata\MediaBundle\Model\MediaInterface $media = null)
    {
        $this->media = $media;
    }

    /**
     * {@inheritdoc}
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getProduct().' | '.$this->getMedia();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @var string
     */
    public $file;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255,nullable=true)
     */
    private $path;

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

//    public function __toArray() {
//        return [
//            path => $this->getPath(),
//        ];
//    }


//
//
//    /**
//     * @ORM\ManyToOne(targetEntity="Product", inversedBy="images")
//     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
//     */
//    protected $product;
//
    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

//    public function getAbsolutePath()
//    {
//        return null === $this->path
//            ? null
//            : $this->getUploadRootDir().'/'.$this->path;
//    }
//
//    public function getWebPath()
//    {
//        return null === $this->path
//            ? null
//            : $this->getUploadDir().'/'.$this->path;
//    }
//
//    protected function getUploadRootDir()
//    {
//        // the absolute directory path where uploaded
//        // documents should be saved
//        return __DIR__.'/../../../../web/'.$this->getUploadDir();
//    }
//
//    protected function getUploadDir()
//    {
//        // get rid of the __DIR__ so it doesn't screw up
//        // when displaying uploaded doc/image in the view.
//        return 'upload/images';
//    }
//
//    /**
//     * @ORM\PrePersist()
//     * @ORM\PreUpdate()
//     */
//    public function preUpload()
//    {
//        if (null !== $this->file) {
//            // do whatever you want to generate a unique name
//            $filename = sha1(uniqid(mt_rand(), true));
//            $this->path = $filename.'.'.$this->getFile()->guessExtension();
//        }
//    }
//
//    /**
//     * @ORM\PostPersist()
//     * @ORM\PostUpdate()
//     */
//    public function upload()
//    {
//        if (null === $this->file) {
//            return;
//        }
//
//        // if there is an error when moving the file, an exception will
//        // be automatically thrown by move(). This will properly prevent
//        // the entity from being persisted to the database on error
//        $this->getFile()->move($this->getUploadRootDir(), $this->path);
//
//        unset($this->file);
//    }
//
//    /**
//     * @ORM\PostRemove()
//     */
//    public function removeUpload()
//    {
//        if ($file = $this->getAbsolutePath()) {
//            unlink($file);
//        }
//    }
//
//    /**
//     * Set property
//     *
//     * @param StockBundle\Entity\Product $property
//     * @return Image
//     */
//    public function setProduct(Product $product)
//    {
//        $this->product = $product;
//
//        return $this;
//    }
//
//    /**
//     * Get property
//     *
//     * @return StockBundle\Entity\Product
//     */
//    public function getProduct()
//    {
//        return $this->product;
//    }
//
    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }


}