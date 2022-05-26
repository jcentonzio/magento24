<?php

namespace Cento\Automation\Helper;

use Magento\Catalog\Api\Data\ProductTierPriceInterfaceFactory;
use Magento\Catalog\Api\ScopedProductTierPriceManagementInterface;
use Cento\Automation\Helper\AddOptionAttribute;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;


class CreateProduct {
    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $_productFactory;
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product
     */
    protected $_resourceModel;
    /**
     * @var SourceItemInterface
     */
    protected $sourceItemsSaveInterface;
    /**
     * @var \Magento\InventoryApi\Api\Data\SourceItemInterfaceFactory
     */
    protected $sourceItem;
    /**
     * @var \Magento\Eav\Api\AttributeRepositoryInterface
     */
    protected $attributeRepository;
    /**
     * @var \Magento\ConfigurableProduct\Helper\Product\Options\Factory
     */
    protected $_optionsFactory;
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;
    /**
     * @var \Magento\Catalog\Setup\CategorySetup
     */
    protected $categorySetup;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    protected $_appState;

    /**
     * @var Magento\CatalogInventory\Api\StockStateInterface
     */
    protected $_stockStateInterface;

    /**
     * @var Magento\CatalogInventory\Api\StockRegistryInterface
     */
    protected $_stockRegistry;

    protected $_categories;

    /**
     * @var ScopedProductTierPriceManagementInterface
     */
    private $tierPrice;

    /**
     * @var ProductTierPriceInterfaceFactory
     */
    private $productTierPriceFactory;

    protected $_addOptionAttribute;

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
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Model\ResourceModel\Product $resourceModel,
        \Magento\InventoryApi\Api\Data\SourceItemInterface $sourceItemsSaveInterface,
        \Magento\InventoryApi\Api\Data\SourceItemInterfaceFactory $sourceItem,
        \Magento\Eav\Api\AttributeRepositoryInterface $attributeRepository,
        \Magento\ConfigurableProduct\Helper\Product\Options\Factory $optionsFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Setup\CategorySetup $categorySetup,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\State $appState,
        \Magento\CatalogInventory\Api\StockStateInterface $stockStateInterface,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry,
        \Cento\Automation\Helper\Categories $categories,
        ScopedProductTierPriceManagementInterface $tierPrice,
        ProductTierPriceInterfaceFactory $productTierPriceFactory,
        AddOptionAttribute $addOptionAttribute,
        DirectoryList $directoryList,
        Filesystem $filesystem,
        \Magento\Framework\Filesystem\Driver\File $fileDriver
    )
    {
        $this->_productFactory = $productFactory;
        $this->_resourceModel = $resourceModel;
        $this->sourceItemsSaveInterface = $sourceItemsSaveInterface;
        $this->sourceItem = $sourceItem;
        $this->attributeRepository = $attributeRepository;
        $this->_optionsFactory = $optionsFactory;
        $this->productRepository = $productRepository;
        $this->categorySetup = $categorySetup;
        $this->storeManager = $storeManager;
        $this->_appState = $appState;
        $this->_stockStateInterface = $stockStateInterface;
        $this->_stockRegistry = $stockRegistry;
        $this->_categories = $categories;
        $this->tierPrice = $tierPrice;
        $this->productTierPriceFactory = $productTierPriceFactory;
        $this->_addOptionAttribute = $addOptionAttribute;
        $this->directoryList = $directoryList;
        $this->filesystem = $filesystem;
        $this->_fileDriver = $fileDriver;

    }

    public function execute($params)
    {

        $product = $this->_productFactory->create();
        $sourceItems = [];

        $sourceCategoryOne = $this->_categories->getFindCategory($params->nombreclasif1);
        $sourceCategorySecond = $this->_categories->getFindCategory($params->nombreclasif2);

        $categorySet[] = $sourceCategoryOne['id'];
        $categorySet[] = $sourceCategorySecond['id'];

        $idManufacturer = $this->_addOptionAttribute->findManufacturerOption($params->descripmarca);

        try {

                echo "importando producto";
                echo "</br>";

                $product->unsetData();
                $product->setTypeId('simple')
                    ->setAttributeSetId(4)
                    ->setWebsiteIds([1])
                    ->setName($params->nombre)
                    ->setSku($params->codigo)
                    ->setPrice($params->preciominorista)
                    ->setWeight(1)
                    ->setManufacturer($idManufacturer)
                    ->setVisibility(4)
                    ->setStatus(1)
                    ->setTaxClassId(0)
                    ->setCategoryIds($categorySet);

            $imagePath = $this->directoryList->getPath('pub');
            $fileName = $params->codigo;

            for ($i = 3; $i < 12; $i++) {
                $path = $imagePath . '/media/import-images/product/'. $fileName . '-'. $i .  '.jpg';
                if($this->_fileDriver->isExists($path)) {
                    $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/import.log');
                    $logger = new \Zend\Log\Logger();
                    $logger->addWriter($writer);
                    $logger->info("se encontro archivo {$path}");
                    $product->addImageToMediaGallery($path, array('image', 'small_image', 'thumbnail'), true, false);
                } else {
                    $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/import.log');
                    $logger = new \Zend\Log\Logger();
                    $logger->addWriter($writer);
                    $logger->info("no se encontro archivo {$path}");
                }
            }

             $this->_resourceModel->save($product);

             $stockData = [
                 'is_in_stock' => 1,
                 'qty' => 100,
                 'manage_stock' => 1,
             ];

            $stockItem= $this->_stockRegistry->getStockItem($product->getId()); // load stock of that product
            $stockItem->setData('is_in_stock',$stockData['is_in_stock']); //set updated data as your requirement
            $stockItem->setData('qty',$stockData['qty']); //set updated quantity
            $stockItem->setData('manage_stock',$stockData['manage_stock']);
            $stockItem->setData('use_config_notify_stock_qty',1);
            $stockItem->save();

            $tierPriceData = $this->productTierPriceFactory->create();

            $precioMayorista = "{$params->preciomayorista}.01";

            $precioMayorista = floatval($precioMayorista);

            $tierPriceData->setCustomerGroupId(2)
                ->setQty(1.00)
                ->setValue($precioMayorista);

            $this->tierPrice->add($product->getSku(), $tierPriceData);

            echo "Finalizado con exito";

        } catch (\Exception $e) {
            echo "Error: {$e->getMessage()}";
        }
    }

}




