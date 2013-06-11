<?php
 
  class MailinSms {
	
		protected $key, $to, $from, $notify, $text, $webaction = 'SENDSMS', $url = 'http://ws.mailin.fr/';
		
		public function __construct($key){
			$this->key = $key;
		}
		
		public function addTo($to){
			$this->to = $to;
			return $this;
		}

		public function setFrom($from){
			$this->from = $from;
			return $this;
		}

		public function setNotify($notify_url){
			$this->notify = $notify_url;
			return $this;
		}

		public function setText($text){
			$this->text = $text;
			return $this;
		}

		public function setTag($text){
			$this->tag = $text;
			return $this;
		}

		public function send(){
		
			$ch = curl_init();
			$data = array(
				'webaction' => $this->webaction,	
				'key' => $this->key,	
				'to' => $this->to,	
				'from' => $this->from,	
				'text' => $this->text,
				'tag' => $this->tag
			);
	
			$ndata='';
			if(is_array($data)){
				foreach($data AS $key=>$value)
					$ndata .=$key.'='.urlencode($value).'&';
			}else{
				$ndata=$data;
			}

			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
			curl_setopt($ch, CURLOPT_POST,1);
			curl_setopt ($ch, CURLOPT_POSTFIELDS,$ndata);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
			curl_setopt($ch, CURLOPT_URL, $this->url);
			// curl_setopt($ch, CURLOPT_VERBOSE, true);
			$data = curl_exec($ch);
			curl_close($ch);
			return $data;
		}
	}
	
?>