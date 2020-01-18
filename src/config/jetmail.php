<?php

return [

    /**
     * Aşağıda yer alanlar bağlantı adresleri
     * api endpointleri olup, jetmail tarafından
     * değiştirilmedikçe düzenleme yapmayın
     */

    'wswsdlurl' => 'https://www.jetsms.net/jetmailWS/MailService.svc?wsdl',
    'wsbaseurl' => 'https://www.jetsms.net/jetmailWS/MailService.svc?',
    'wsrefurl' => 'http://www.w3.org/2005/08/addressing',


    /**
     * Gönderen bilgilerinin boş bırakılmsaı halinde
     * bu config dosyasında yer alan bilgiler kullanılacaktır
     * Config dosyasının boş bırakılması halinde ise
     * laravele ait mail.php içerisinde yer alan bilgilere
     * başvurulacaktır
     *
     */
    'from' => [
        'address' => 'hotelmaster@posta.jetmail.com.tr',
        'name' => 'Hotel Master',
    ],

    /**
     * Jetmail tarafından size verilen doğrulama
     * tokenini ve kullanıcı adınızı girin.
     */
    'auth' => [
        'token' => 'jetmailtarafındanverilentoken',
        'username' => 'hsntngr'
    ],

    'soap' => [
        'version' => SOAP_1_2,
        'trace' => 1,
        'exceptions' => 0
    ]
];