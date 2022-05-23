<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_RegionUpload
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\RegionUpload\Model;

use Magento\Directory\Model\RegionFactory;

class SaveRegion
{

    protected $resultPageFactory;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * Undocumented function
     *
     * @param RegionFactory $regionFactory
     */
    public function __construct(
        RegionFactory $regionFactory
    ) {
        $this->regionFactory = $regionFactory;
    }

    /**
     * Save Region Code
     *
     * @param array $data
     * @param string $countryId
     * @return array $result
     */
    public function saveRegionCodeCsv($data, $countryId)
    {
        try {
            $regionModel = $this->regionFactory->create();
            $regionModel->setCountryId($countryId);
            $regionModel->setCode($data[0]);
            $regionModel->setDefaultName($data[1]);
            $regionModel->setIsManual(1);
            $regionModel->save();
            $result = [
                'error' => false
            ];
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $result = ['error' => true, 'msg' => $msg];
        }
        return $result;
    }

    /**
     * Save region code
     *
     * @param array $param
     * @return array $result
     */
    public function saveRegion($param)
    {
        $countryId = $param['wk_country_id'];
        $code = $param['wk_region_code'];
        $name = $param['wk_region_name'];
        $isManual = 1;
        $data = [
            "country_id" => $countryId,
            "code" => $code,
            "default_name" => $name,
            "is_manual" => $isManual
        ];
        try {
            $regionColl = $this->regionFactory->create();
            $regionColl->addData($data)->save()->getId();
            $result = [
                'message' => __('Region Code Successfully Added.'),
                'error' => false
            ];
        } catch (\Exception $e) {
            $result = [
                'message' => $e->getMessage(),
                'error' => true
            ];
        }
        return $result;
    }
}
