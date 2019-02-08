<?php

namespace JeacCorp\Test\Mpandco\Api\Payment;

use JeacCorp\Test\Mpandco\BaseTest;
use JeacCorp\Mpandco\Api\Payment\PaymentIntent;
use JeacCorp\Mpandco\Rest\Client;

/**
 * Test de intencion de pago
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PaymentIntentTest extends BaseTest
{

    public function testUnserialize()
    {
        $client = new Client();
        $data = $this->getJsonPaymentIntent();
        $paymentIntent = $client->getSerializer()->deserialize($data,PaymentIntent::class,"json");
        $this->checkData($paymentIntent);

        $data = $client->getSerializer()->serialize($paymentIntent,"json");
        $paymentIntent = $client->getSerializer()->deserialize($data,PaymentIntent::class,"json");
        $this->checkData($paymentIntent);
    }
    
    private function checkData(PaymentIntent $paymentIntent)
    {
        $propertyAccessor = \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor();
        $this->assertEquals("03b9f66c-fefb-11e8-a647-b62cbc289574",$propertyAccessor->getValue($paymentIntent,"id"));
        $this->assertEquals("sale",$propertyAccessor->getValue($paymentIntent,"intent"));
        $this->assertEquals("created",$propertyAccessor->getValue($paymentIntent,"state"));
        $this->assertEquals("http://localhost/payments/ExecutePayment.php?success=true&carId=200",$propertyAccessor->getValue($paymentIntent,"redirect_urls.return_url"));
        $this->assertEquals("http://localhost/payments/ExecutePayment.php?success=false&carId=200",$propertyAccessor->getValue($paymentIntent,"redirect_urls.cancel_url"));
        $this->assertEquals("VES",$propertyAccessor->getValue($paymentIntent,"total.currency.id"));
        $this->assertEquals("17.5",$propertyAccessor->getValue($paymentIntent,"total.items"));
        $this->assertEquals("2",$propertyAccessor->getValue($paymentIntent,"total.shipping"));
        $this->assertEquals("1.3",$propertyAccessor->getValue($paymentIntent,"total.tax"));
        $this->assertEquals("18.8",$propertyAccessor->getValue($paymentIntent,"total.amount"));
        
        $this->assertEquals("03bb1538-fefb-11e8-a647-b62cbc289574",$propertyAccessor->getValue($paymentIntent,"transactions[0].id"));
        $this->assertEquals("VES",$propertyAccessor->getValue($paymentIntent,"transactions[0].amount.currency.id"));
        $this->assertEquals("20",$propertyAccessor->getValue($paymentIntent,"transactions[0].amount.total"));
        $this->assertEquals("1",$propertyAccessor->getValue($paymentIntent,"transactions[0].amount.details.shipping"));
        $this->assertEquals("1.3",$propertyAccessor->getValue($paymentIntent,"transactions[0].amount.details.tax"));
        $this->assertEquals("17.5",$propertyAccessor->getValue($paymentIntent,"transactions[0].amount.details.sub_total"));
        $this->assertEquals("telefono",$propertyAccessor->getValue($paymentIntent,"transactions[0].items[0].name"));
        $this->assertEquals("1",$propertyAccessor->getValue($paymentIntent,"transactions[0].items[0].quantity"));
        $this->assertEquals("VES",$propertyAccessor->getValue($paymentIntent,"transactions[0].items[0].currency.id"));
        $this->assertEquals("P001",$propertyAccessor->getValue($paymentIntent,"transactions[0].items[0].sku"));
        $this->assertEquals("7.5",$propertyAccessor->getValue($paymentIntent,"transactions[0].items[0].price"));
        $this->assertEquals("Compra por eBay",$propertyAccessor->getValue($paymentIntent,"transactions[0].description"));
        $this->assertEquals("F00015",$propertyAccessor->getValue($paymentIntent,"transactions[0].invoice_number"));
        
        $this->assertEquals("http://app.mpandco.com/api/payment-intent/show?id=03b9f66c-fefb-11e8-a647-b62cbc289574",$paymentIntent->getLink("self")->getHref());
        $this->assertEquals("GET",$paymentIntent->getLink("self")->getMethod());
        $this->assertEquals("http://app.mpandco.com/api/payment-intent/execute/sale?id=03b9f66c-fefb-11e8-a647-b62cbc289574",$paymentIntent->getLink("execute")->getHref());
        $this->assertEquals("POST",$paymentIntent->getLink("execute")->getMethod());
        $this->assertEquals("http://app.mpandco.com/p/express-checkout/03b9f66c-fefb-11e8-a647-b62cbc289574/1",$paymentIntent->getLink("approval_url")->getHref());
        $this->assertEquals("GET",$paymentIntent->getLink("approval_url")->getMethod());
    }

    public function getJsonPaymentIntent()
    {
        return '{
                    "id":"03b9f66c-fefb-11e8-a647-b62cbc289574",
                    "intent":"sale",
                    "state":"created",
                    "redirect_urls":{
                    "return_url":"http:\/\/localhost\/payments\/ExecutePayment.php?success=true&carId=200",
                    "cancel_url":"http:\/\/localhost\/payments\/ExecutePayment.php?success=false&carId=200",
                    "history_responses":[
                    ]
                    },
                      "total":{
                         "currency":{
                            "id":"VES"
                          },
                          "items":17.5,
                          "shipping":2,
                          "tax":1.3,
                          "amount":18.8
                      },
                       "transactions":[
                          {
                             "id":"03bb1538-fefb-11e8-a647-b62cbc289574",
                             "amount":{
                                "currency":{
                                   "id":"VES"
                                },
                                "total":20,
                                "details":{
                                   "shipping":1,
                                   "tax":1.3,
                                   "sub_total":17.5
                                }
                             },
                             "items":[
                                {
                                  "name":"telefono",
                                  "quantity":1,
                                  "currency":{
                                    "id":"VES"
                                   },
                                   "sku":"P001",
                                   "price":7.5
                                }
                             ],
                             "description":"Compra por eBay",
                             "invoice_number":"F00015",
                             "pay_tokens":[

                             ]
                          }
                       ],
                       "_links":{
                          "self":{
                               "href":"http:\/\/app.mpandco.com\/api\/payment-intent\/show?id=03b9f66c-fefb-11e8-a647-b62cbc289574",
                               "method":"GET"
                         },
                         "execute":{
                                "href":"http:\/\/app.mpandco.com\/api\/payment-intent\/execute\/sale?id=03b9f66c-fefb-11e8-a647-b62cbc289574",
                                "method":"POST"
                          },
                           "approval_url":{
                                "href":"http:\/\/app.mpandco.com\/p\/express-checkout\/03b9f66c-fefb-11e8-a647-b62cbc289574\/1",
                                "method":"GET"
                          }
                       }
                    }
                    ';
    }

}