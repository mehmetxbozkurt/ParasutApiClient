# ParasutApiClient
Usage  

POST 
:

	require_once "class.api.parasut.php";
	$PRS = new \ParasutApi\Parasut();

	$responsePost = $PRS->apiTokenPost("sales_invoices",json_decode($params));
	$resArr = json_decode($responsePost);
	$fatura_id = $resArr->sales_invoice->id;	


GET : 



		require_once "class.api.parasut.php";
        $PRS = new \ParasutApi\Parasut();

        $params=array("per_page"=>100);
        $page = "item_categories";

        $page_response = $PRS->apiTokenGet($page,$params);

        $categories=  json_decode( $page_response );



PUT : 


                require "class.api.parasut.php";
                $PRS = new \ParasutApi\Parasut();
                */
                $params='{
                          "contact": {
                            "name": "'.$name.'",
                            "contact_type": "person",
                            "email": "'.$email.'",
                            "tax_number": "'.$tax_number.'",
                            "tax_office": null,
                            "category_id": $category_id,
                            "city": "'.$city.'",
                            "district": "'.$district.'",
                            "address_attributes": {
                              "address": "'.$address.'",
                              "fax": $fax,
                              "phone": "'.$phone.'"
                            },
                            "contact_people_attributes": [
                              {
                                "name": $contact_people_name,
                                "name": $contact_people_name,
                                "email": $contact_people_email,
                                "notes": $contact_people_notes
                              }
                            ]
                          }
                        }';

                $response = $PRS->apiTokenPut("contacts",$contact_id,json_decode($params));



DELETE : 


        $PRS = new \ParasutApi\Parasut();
        $responseDelete = $PRS->apiTokenDelete("sales_invoices", $si_id]);
        $resArr = json_decode($responseDelete);
        if ($resArr->success == "OK") {
        	echo "Sales invoice deleted";
        }


