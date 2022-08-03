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

    protected $resourceConnection;


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
        ScopedProductTierPriceManagementInterface $tierPrice,
        ProductTierPriceInterfaceFactory $productTierPriceFactory,
        \Magento\Framework\App\ResourceConnection $resourceConnection
    )
    {
        $this->_resourceModel = $resourceModel;
        $this->productRepository = $productRepository;
        $this->tierPrice = $tierPrice;
        $this->productTierPriceFactory = $productTierPriceFactory;
        $this->resourceConnection = $resourceConnection;
    }

    public function execute($productId, $params)
    {

        $product = $this->productRepository->getById($productId);

        try {

            echo "Actualizando producto {$product->getSku()} \n";

            $product->setPrice($params['minoristabruto']);

            //$this->_resourceModel->save($product);
            $this->_resourceModel->saveAttribute($product, 'price');

            $tierPriceData = $this->productTierPriceFactory->create();

            $precioMayorista = "{$params['mayoristaneto']}.01";

            $precioMayorista = floatval($precioMayorista);

            $tierPriceData->setCustomerGroupId(2)
                ->setQty(1.00)
                ->setValue($precioMayorista);

            $this->tierPrice->add($product->getSku(), $tierPriceData);

            $connection = $this->resourceConnection->getConnection();

            if($params['stock'] > 0) {
                $stockStatus = 1;
            } else {
                $stockStatus = 0;
            }

            $data = ["qty"=>$params['stock'], "is_in_stock" => $stockStatus];
            $id = $productId;
            $where = ['product_id = ?' => (int)$id];

            $tableName = $connection->getTableName("cataloginventory_stock_item");
            $connection->update($tableName, $data, $where);


        } catch (\Exception $e) {
            echo "Error: {$e->getMessage()} \n";
        }
    }

}
