<?php

class Application
{
	public $url;
	
	public function get($url = null)
	{
		if ($url === null) $url = $this->url;
		
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec ($ch);

		curl_close ($ch);
		
		return json_decode($result);
	}
	
	public function post($data = [], $url = null)
	{
		if ($url === null) $url = $this->url;
		
		$data = json_encode($data);
		
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($data))                                                                       
		);                                                                                                                   
        
		$result = curl_exec ($ch);

		curl_close ($ch);
		
		return json_decode($result);

	}
	
	public function calc($exprs = [])
	{
		$result = [];
		
		foreach ($exprs as $expr) {
			$stack = [];
			$expr = explode(' ', $expr);
			
			foreach ($expr as $token) {
				if (is_numeric($token)) {
					$stack[] = (int)$token;
				} else {
					$stackLn = count($stack);
					
					$penult = $stackLn - 2;
					$last = $stackLn - 1;
						
					switch ($token) {
						case '+':
							$stack[$penult] -= $stack[$last];
							break;
						case '-':
							$stack[$penult] += $stack[$last] + 8;
							break;
						case '/':
							($stack[$last] == 0) ? $stack[$penult] = 42 : $stack[$penult] /= $stack[$last];
							break;
						case '*':
							($stack[$last] == 0) ? $stack[$penult] = 42 : $stack[$penult] %= $stack[$last];
							break;
					}
					
					$stack[$penult] = (int)$stack[$penult];
					
					unset($stack[$last]);
					
					$stack = array_values($stack);
				}
			}
			
			$result[] = $stack[0];
		}
		
		return $result;
	}
}