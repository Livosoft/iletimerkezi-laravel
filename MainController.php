<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;


class ActionController extends Controller
{
  
    public static function sendRequest($address, $send_xml)
    {

        $ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL,$address);
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_POSTFIELDS,$send_xml);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,2);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    	curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: text/xml'));
    	curl_setopt($ch, CURLOPT_HEADER, 0);
    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 120);

    	$result = curl_exec($ch);

    	return $result;

    }

    //İşlem Başarılı
    public function success($tokens)
    {
        $username   = 'xxxx';
        $password   = 'xxxx';
        $header     = 'başlık';
        $message    = 'Merhaba mesaj içeriği';
        $number     = 'telefon_no';
        $date       = 'xxxxxx'; 

        $xml = <<<EOS
                    <request>
                            <authentication>
                                    <username>{$username}</username>
                                    <password>{$password}</password>
                            </authentication>
                            <order>
                                <sender>{$header}</sender>
                                <sendDateTime>{$date}</sendDateTime>
                                <message>
                                    <text><![CDATA[{$message}]]></text>
                                    <receipents>
                                        <number>{$number}</number>
                                    </receipents>
                                </message>
                            </order>
                    </request>
        EOS;
        $result = self::sendRequest('http://api.iletimerkezi.com/v1/send-sms', $xml);


        return view('frontend.main.success');
    }

 

}
