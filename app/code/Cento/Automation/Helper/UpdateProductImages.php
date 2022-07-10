<?php

namespace Cento\Automation\Helper;


use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class PriceStock
 *
 * @package \Cento\Automation\Helper
 */
class UpdateProductImages
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product
     */
    protected $_resourceModel;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    protected $imageProcessor;
    protected $_gallery;

    /**
     * @var DirectoryList
     */
    private $directoryList;

    /**
     * @var Filesystem
     */
    private $filesystem;

    protected $_fileDriver;

    public function __construct(

        \Magento\Catalog\Model\Product $resourceModel,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Model\Product\Gallery\Processor $imageProcessor,
        \Magento\Catalog\Model\ResourceModel\Product\Gallery $gallery,
        DirectoryList $directoryList,
        Filesystem $filesystem,
        \Magento\Framework\Filesystem\Driver\File $fileDriver
    )
    {
        $this->_resourceModel = $resourceModel;
        $this->productRepository = $productRepository;
        $this->imageProcessor = $imageProcessor;
        $this->_gallery = $gallery;
        $this->directoryList = $directoryList;
        $this->filesystem = $filesystem;
        $this->_fileDriver = $fileDriver;
    }

    public function execute($productId)
    {
        $product = $this->_resourceModel->load(1439);

        try {

            echo "Actualizando imagen de producto {$product->getSku()} \n";

            $existingMediaGalleryEntries = $product->getMediaGalleryEntries();
            if(is_array($existingMediaGalleryEntries)) {
                foreach ($existingMediaGalleryEntries as $key => $entry) {
                    unset($existingMediaGalleryEntries[$key]);
                    $image = $entry->getFile();

                    $this->imageProcessor->removeImage($product, $image);
                    $this->_gallery->deleteGallery($entry->getId());

                    $image = 'pub/media/catalog/product' . $image;
                    if(file_exists($image)) {
                        unlink($image);
                    }
                }
            }

            $product->setMediaGalleryEntries($existingMediaGalleryEntries);

            $imagePath = $this->directoryList->getPath('pub');
            $fileName = $product->getSku();

            for ($i = 3; $i < 12; $i++) {
                $path = $imagePath . '/media/import-images/product/'. $fileName . '-'. $i .  '.jpg';
                if($this->_fileDriver->isExists($path)) {
                    $product->addImageToMediaGallery($path, array('image', 'small_image', 'thumbnail'), false, false);
                }
            }

            $this->productRepository->save($product);
            die();

        } catch (\Exception $e) {
            echo "Error: {$e->getMessage()} \n";
        }
    }

}
