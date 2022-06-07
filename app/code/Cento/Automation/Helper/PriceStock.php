<?php

namespace Cento\Automation\Helper;

use Magento\Catalog\Api\Data\ProductTierPriceInterfaceFactory;
use Magento\Catalog\Api\ScopedProductTierPriceManagementInterface;

/**
 * Class PriceStock
 *
 * @package \Cento\Automation\Helper
 */
class PriceStock
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product
     */
    protected $_resourceModel;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var Magento\CatalogInventory\Api\StockRegistryInterface
     */
    protected $_stockRegistry;

    /**
     * @var ScopedProductTierPriceManagementInterface
     */
    private $tierPrice;

    /**
     * @var ProductTierPriceInterfaceFactory
     */
    private $productTierPriceFactory;

    public function __construct(

        \Magento\Catalog\Model\ResourceModel\Product $resourceModel,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry,
        ScopedProductTierPriceManagementInterface $tierPrice,
        ProductTierPriceInterfaceFactory $productTierPriceFactory
    )
    {
        $this->_resourceModel = $resourceModel;
        $this->productRepository = $productRepository;
        $this->_stockRegistry = $stockRegistry;
        $this->tierPrice = $tierPrice;
        $this->productTierPriceFactory = $productTierPriceFactory;
    }

    public function execute($productId, $params)
    {

        $product = $this->productRepository->getById($productId);

        try {

            echo "Actualizando producto {$product->getSku()} \n";

            $product->setPrice($params['preciominorista']);

            $this->_resourceModel->save($product);

            $stockData = [
                'is_in_stock' => 1,
                'qty' => $params['stock'],
                'manage_stock' => 1,
            ];

            $stockItem= $this->_stockRegistry->getStockItem($product->getId()); // load stock of that product
            $stockItem->setData('is_in_stock',$stockData['is_in_stock']); //set updated data as your requirement
            $stockItem->setData('qty',$stockData['qty']); //set updated quantity
            $stockItem->setData('manage_stock',$stockData['manage_stock']);
            $stockItem->setData('use_config_notify_stock_qty',1);
            $stockItem->save();

            $tierPriceData = $this->productTierPriceFactory->create();

            $precioMayorista = "{$params['preciomayorista']}.01";

            $precioMayorista = floatval($precioMayorista);

            $tierPriceData->setCustomerGroupId(2)
                ->setQty(1.00)
                ->setValue($precioMayorista);

            $this->tierPrice->add($product->getSku(), $tierPriceData);


        } catch (\Exception $e) {
            echo "Error: {$e->getMessage()} \n";
        }
    }

}
