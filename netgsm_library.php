<?php
/*
 * NETGSM API İLE SMS GÖNDERMEK
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class netgsm_library {
    private $username= "506*******";
    private $pass= "***";
    function sendsms($msg, $telno, $header)
    {
        $startdate=date('dmYHi');
        $stopdate="";
        $encoded_msg = urlencode($msg);
        $url="https://api.netgsm.com.tr/bulkhttppost.asp?usercode=$this->username&password=$this->pass&gsmno=$telno&message=$encoded_msg&msgheader=$header&startdate=$startdate&stopdate=$stopdate";
        $output = $this->Curl($url);
        return $output;
    }
    function Curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $output=curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    function ErrorResult($outputCode)
    {
        $sonuc="";
        if($outputCode=="00"){
            $sonuc = "Mesaj başarıyla gönderilmiştir.";
        }elseif($outputCode=="01" || $outputCode=="01" ){
            $sonuc = "Başlangıç veya bitiş tarihinde hata var.";
        }elseif($outputCode=="20"){
            $sonuc = "Mesajdaki maksimum karakter sayısı aşıldı.";
        }elseif($outputCode=="30"){
            $sonuc = "API kullanıcı adı veya şifresi yanlış.";
        }elseif($outputCode=="40"){
            $sonuc = "Sistemde tanımlı olmayan mesaj başlığı girilmiştir.";
        }elseif($outputCode=="70"){
            $sonuc = "Parametrelerden birisi hatalı veya zorunlu alanlardan biri eksik olarak girilmiş.";
        }
        return $sonuc;
    }
}