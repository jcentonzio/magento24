<?php

namespace Cento\Automation\Helper;

use Exception;
use Magento\Catalog\Api\CategoryListInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

/**
 * Class Categories
 *
 * @package \Cento\Automation\Helper
 */
class Categories
{
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var CategoryListInterface
     */
    private $categoryList;

    public function __construct(
        CategoryListInterface $categoryList,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->categoryList = $categoryList;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Fetch all Category list
     *
     * @return array
     */
    public function getAllCategories()
    {
        $categories = [];
        try {
            $searchCriteria = $this->searchCriteriaBuilder->create();
            $categorySystem = $this->categoryList->getList($searchCriteria);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        foreach ($categorySystem->getItems() as $item) {
            $categories[] = [
                "name" => $item->getName(),
                "id" => $item->getId()
            ];
        }

        return  $categories;
    }


    public function getFindCategory($category) {
        $i = array_search($category, array_column($this->getAllCategories(), 'name'));
        $categories = $this->getAllCategories();
        return $categories[$i];

    }


}
