<?php

namespace Cento\Automation\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\ImportExport\Model\Import\Adapter as ImportAdapter;
use Magento\ImportExport\Model\Import\ErrorProcessing\ProcessingErrorAggregatorInterface;

class Import
{
    const ENTITY = 'catalog_product'; //catalog_product, customer, advanced_pricing...
    const BEHAVIOR = 'append'; //append, replace, delete


    protected $importModel;

    protected $fileSystem;

    /**
     * ImportCron constructor.
     * @param \Magento\ImportExport\Model\Import $importModel
     * @param \Magento\Framework\Filesystem $filesystem
     */
    public function __construct(
        \Magento\ImportExport\Model\Import $importModel,
        \Magento\Framework\Filesystem $filesystem

    )
    {
        $this->importModel = $importModel;
        $this->fileSystem = $filesystem;
    }

    public function execute($file, $typeEntity){

        try{

            $fileName = $file;
            $skipValidate = true;

            $sourceFile = $this->importModel->getWorkingDir() . self::ENTITY . '.csv';
            $importedFile = $this->importModel->getWorkingDir() . $fileName;

            if (strtolower($fileName) != $typeEntity . '.csv') {
                copy($importedFile, $sourceFile);
            }

            $data = array(
                'entity' => $typeEntity,
                'based_entity' => $typeEntity,
                'behavior' => self::BEHAVIOR,
                $this->importModel::FIELD_NAME_VALIDATION_STRATEGY => $skipValidate ? ProcessingErrorAggregatorInterface::VALIDATION_STRATEGY_SKIP_ERRORS : ProcessingErrorAggregatorInterface::VALIDATION_STRATEGY_STOP_ON_ERROR,
                $this->importModel::FIELD_NAME_ALLOWED_ERROR_COUNT => 10,
                $this->importModel::FIELD_FIELD_MULTIPLE_VALUE_SEPARATOR => \Magento\ImportExport\Model\Import::DEFAULT_GLOBAL_MULTI_VALUE_SEPARATOR,
                $this->importModel::FIELD_FIELD_SEPARATOR => ',',
                $this->importModel::FIELD_NAME_IMG_FILE_DIR => 'pub/media/import'
            );


            $this->importModel->setData($data);

            $source = ImportAdapter::findAdapterFor(
                $sourceFile,
                $this->fileSystem->getDirectoryWrite(DirectoryList::ROOT),
                $data[$this->importModel::FIELD_FIELD_SEPARATOR]
            );

            $validationResult = $this->importModel->validateSource($source);

            if (!$this->importModel->getProcessedRowsCount()) {
                if (!$this->importModel->getErrorAggregator()->getErrorsCount()) {
                } else {
                    foreach ($this->importModel->getErrorAggregator()->getAllErrors() as $error) {
                        echo "error";
                    }
                }
            } else {
                $errorAggregator = $this->importModel->getErrorAggregator();
                if (!$validationResult) {
                    foreach ($errorAggregator->getRowsGroupedByErrorCode() as $errorMessage => $rows) {
                        echo "error";
                    }
                } else {
                    if ($this->importModel->isImportAllowed()) {
                        $this->importModel->importSource();
                        $errorAggregator = $this->importModel->getErrorAggregator();
                        if ($errorAggregator->hasToBeTerminated()) {
                            foreach ($errorAggregator->getRowsGroupedByErrorCode() as $errorMessage => $rows) {
                                echo "error";
                            }
                        } else {
                            $this->importModel->invalidateIndex();
                            foreach ($errorAggregator->getRowsGroupedByErrorCode() as $errorMessage => $rows) {
                                 echo "error";
                            }
                        }

                        //TODO: Move source file to archive or some folder.

                    } else {
                        echo "no import";
                    }
                }
            }
        }
        catch (\Exception $e){
          echo "{$e->getMessage()} {$e->getLine()} \n";
        }

    }

}
