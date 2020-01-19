<?php

class NativeMail {

    public $from;
    public $from_name;
    public $to;
    public $to_name;
    public $header;
    public $message;
    public $attachment;
    public $uid;
    public $subject;
    
    public function __construct($from, $from_name, $to, $subject, $message) {
        $this->uid = md5(uniqid(time()));
        $this->from = $from;
        $this->from_name = $from_name;
        $this->to = $to;
        $this->message = $message;
        $this->subject = $subject;
        
        $this->attachment = '';
    }

    public function setAttachment($file, $filename) {        
        $content = file_get_contents($file);
        $content = chunk_split(base64_encode($content));                
        
        $this->attachment .= "--" . $this->uid . "\r\n";
        $this->attachment .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"\r\n";
        $this->attachment .= "Content-Transfer-Encoding: base64\r\n";
        $this->attachment .= "Content-Disposition: attachment; filename=\"" . $filename . "\"\r\n\r\n";
        $this->attachment .= $content . "\r\n\r\n";        
        
    }

    public function send() {
        

        // header
        $this->header = "From: " . $this->from_name . " <" . $this->from . ">\r\n";
        $this->header .= "Reply-To: no-reply@sylhetshop.co.uk\r\n";
        $this->header .= "MIME-Version: 1.0\r\n";
        $this->header .= "Content-Type: multipart/mixed; boundary=\"" . $this->uid . "\"\r\n\r\n";

        // message & attachment
        $nmessage = "--" . $this->uid . "\r\n";
        $nmessage .= "Content-type:text/html; charset=iso-8859-1\r\n";
        $nmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $nmessage .= $this->message . "\r\n\r\n";        
        
        if($this->attachment != ''){
            $this->attachment .= "--" . $this->uid . "--";
        }
        $nmessage .= $this->attachment;
        
        

        if (mail($this->to, $this->subject, $nmessage, $this->header)) {
            return true; // Or do something here
        } else {
            return false;
        }
    }

}
