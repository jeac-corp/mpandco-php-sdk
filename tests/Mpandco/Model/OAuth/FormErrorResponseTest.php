<?php

/*
 * This file is part of the Jeac Corporation SAS - 901221207-4 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Test\Mpandco\Model\OAuth;

use JeacCorp\Test\Mpandco\BaseTest;
use JeacCorp\Mpandco\Rest\Client;
use JeacCorp\Mpandco\Model\OAuth\FormErrorResponse;

/**
 * Pruebas del error 400 de symfony en el formulario
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class FormErrorResponseTest extends BaseTest
{
    public function testUnserialize()
    {
        $client = new Client();
        $data = $this->getJsonError();
        $errorResponse = $client->getSerializer()->deserialize($data,FormErrorResponse::class,"json");
        $this->checkData($errorResponse);

    }
    
    private function checkData(FormErrorResponse $errorResponse)
    {
        $propertyAccessor = \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor();
        $errors = $errorResponse->getErrors();
        $this->assertEquals("400",$propertyAccessor->getValue($errorResponse,"code"));
        $this->assertEquals("Validation Failed",$propertyAccessor->getValue($errorResponse,"message"));
        $this->assertEquals("Segundo error en el formulario.",$errors->getChildren("transactions")->getChildren("amount")->getChildren("amount")->getChildren("total")->getFirstError());
        
        $this->assertEquals("Primer error en el formulario.", $errorResponse->getOneError());
        $this->assertEquals("Primer error en el formulario.", $errors->getFirstError());
        $this->assertEquals("Segundo error en el formulario.", $errors->getFirstErrorForProperty("transactions"));
        $this->assertEquals("Segundo error en el formulario.", $errorResponse->getFirstErrorForProperty("transactions"));
        
    }
    
    public function getJsonError()
    {
        return '
{
    "code": 400,
    "message": "Validation Failed",
    "errors": {
        "errors": [
            "Primer error en el formulario.",
            "Este formulario no deber\u00eda contener campos adicionales."
        ],
        "children": {
            "intent": [],
            "redirectUrls": {
                "children": {
                    "returnUrl": [],
                    "cancelUrl": []
                }
            },
            "transactions": {
                "children": {
                    "amount": {
                        "children": {
                            "digitalAccountDestination": [],
                            "amount": {
                                "children": {
                                    "total": {
                                        "errors": [
                                            "Segundo error en el formulario."
                                        ]
                                    },
                                    "currency": [],
                                    "details": {
                                        "children": {
                                            "shipping": [],
                                            "tax": [],
                                            "subTotal": []
                                        }
                                    }
                                }
                            },
                            "description": {
                                "errors": [
                                    "Este valor no deber\u00eda estar vac\u00edo."
                                ]
                            },
                            "invoiceNumber": [],
                            "items": [],
                            "distributions": []
                        }
                    },
                    "description": {
                        "children": {
                            "digitalAccountDestination": [],
                            "amount": {
                                "children": {
                                    "total": [],
                                    "currency": [],
                                    "details": {
                                        "children": {
                                            "shipping": [],
                                            "tax": [],
                                            "subTotal": []
                                        }
                                    }
                                }
                            },
                            "description": [],
                            "invoiceNumber": [],
                            "items": [],
                            "distributions": []
                        }
                    },
                    "items": {
                        "children": {
                            "digitalAccountDestination": [],
                            "amount": {
                                "children": {
                                    "total": {
                                        "errors": [
                                            "Este valor no deber\u00eda ser nulo."
                                        ]
                                    },
                                    "currency": [],
                                    "details": {
                                        "children": {
                                            "shipping": [],
                                            "tax": [],
                                            "subTotal": []
                                        }
                                    }
                                }
                            },
                            "description": {
                                "errors": [
                                    "Este valor no deber\u00eda estar vac\u00edo."
                                ]
                            },
                            "invoiceNumber": [],
                            "items": [],
                            "distributions": []
                        }
                    }
                }
            },
            "recipient": []
        }
    }
}';
    }
}
