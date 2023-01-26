<?php

namespace Cento\Automation\Cron;

use Transbank\Webpay\Model\WebpayOrderDataFactory;


class SendNvv
{
    protected $logger;
    protected $orderRepository;
    protected $webpayOrderDataFactory;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        WebpayOrderDataFactory $webpayOrderDataFactory
    )
    {
        $this->logger = $logger;
        $this->orderRepository = $orderRepository;
        $this->webpayOrderDataFactory = $webpayOrderDataFactory;
    }

    public function execute() {

        $orderId = 26;

        $order = $this->orderRepository->get($orderId);

        $rutEmpresa = substr($order->getShippingAddress()->getData('rut_empresa'), 0, -2);

        $rutEmpresa = $this->clean($rutEmpresa);

        $rut = substr($order->getShippingAddress()->getData('rut'), 0, -2);

        $rut = $this->clean($rut);

        $webpayOrderData = $this->webpayOrderDataFactory->create();

        $webpayOrderData = $webpayOrderData->load($orderId, 'order_id');

        $trans = $webpayOrderData->getData('metadata');

        $trans = json_decode($trans);

       if($webpayOrderData->getPaymentStatus() === "SUCCESS") {

           if($trans->paymentTypeCode === "VD" || $trans->paymentTypeCode === "VP" ) {
               $typePayment = "3";
           } else {
               $typePayment = "2";
           }

       } else {
           $typePayment = "";
       }


        //var_dump(json_encode($order->getShippingAddress()->getData()));die();

        $items = $order->getAllVisibleItems();

        $detalle = [];

        foreach($items as $i) {

            $detalle[] = [
                "CodigoProducto" => $i->getSku(),
                "CantidadSolicitada" => round($i->getQtyOrdered()),
                "Descripcion" => $i->getName(),
                "ValorUnitarioNeto" => round($i->getPrice()),
                "TotalNeto" => round($i->getRowTotal())
            ];

        }

        $data = [
            "Documento" => [
                "Entidad" => [
                    "Empresa" => $order->getShippingAddress()->getData('razon_social')?? '',
                    "Codigocliente" => "0",
                    "Nombre" => "{$order->getCustomerFirstname()} {$order->getCustomerLastname()}",
                    "Rut" =>  $rutEmpresa ?? $rut,
                    "Giro" => $order->getShippingAddress()->getData('giro')?? '',
                    "Direccion" => $order->getShippingAddress()->getData('street'),
                    "Comuna" => "6",
                    "Ciudad" => "1",
                    "Telefono" => $order->getBillingAddress()->getTelephone(),
                    "Celular" => $order->getBillingAddress()->getTelephone(),
                    "Email" => $order->getCustomerEmail()
                ],
                "Encabezado" => [
                    "FechaEmision" =>  date('Y-m-d'),
                    "CodigoVendedor" => "25",
                    "TipoDocVenta" => "0",
                    "Folio" => "WEB{$order->getIncrementId()}",
                    "Observaciones" => "",
                    "SubTotalNeto" => round($order->getSubtotal()),
                    "PcntDcto" => round($order->getDiscountAmount()),
                    "TotalNeto" => round($order->getSubtotal()),
                    "PcntIva" => round($order->getBaseTaxAmount()),
                    "TotalBruto" => round($order->getGrandTotal())
                ],
                "Pago" => [
                    "FormaDePago" => $typePayment?? "",
                    "ObservacionesPagoWebPay" => $trans->status ?? "Rechazado",
                    "pw_NroCuotas" => $trans->installmentsNumber?? "",
                    "pw_TipodePago" => $trans->paymentTypeCode?? "",
                    "pw_Tarjeta" => $trans->cardDetail->card_number?? "",
                    "pw_formapago" => $trans->paymentTypeCode?? "",
                    "pw_CodigoRetorn" => ""
                ],
                "Detalle" => $detalle
            ]
        ];

        $data = json_encode($data);

        var_dump($data);die();
    }

    public function clean($string) {
        $string = str_replace(' ', '-', $string);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }


}
