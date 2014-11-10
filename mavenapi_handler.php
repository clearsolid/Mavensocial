class MAVEN_API {

		protected $_username 	= null;
		protected $_password 	= null;
		protected $_method 	= null;
		protected $_host 	= null;
		protected $_data	= null;

		protected $_debug 	= false;

		public function __construct($username,$password,$host) {

			$this->_username 	= $username;
			$this->_password 	= $password;
			$this->_host 		= $host;

		}
		public static function create($username,$password,$host="yourhostnamehere") 	{ return new MAVEN_API($username,$password,$host); }
		public function set_method($method) 							{ $this->_method = $method; }
		public function set_data($data) 								{ $this->_data = $data; }

		public function get_method() 									{ return $this->_method; }
		public function get_username() 			   						{ return $this->_username; }
		public function get_password() 			   						{ return $this->_password; }
		public function get_data() 										{ return $this->_data; }

		public function debug() 				  						{ $this->_debug = true; return $this; }
		public function is_debug() 				   						{ return $this->_debug; }

		public function get_requestlist() { return array(	"authtoken.get",
															"contact.create",
															"contact.get",
															"contact.getbyid",
															"contact.getcustomfields",
															"contact.getsharepurl",
															"contact.update",
															"contacts.bysite",
															"contacts.get",
															"contest.submit",
															"contest.vote",
															"contestentries.get",
															"contestentry.get",
															"order.track",
															"social.post_facebook",
															"social.post_twitter",
															"social.post_linkedin",
															"user.create",
															"user.delete",
															"user.get",
															"user.getsites",
															"user.modify",
															"visitsession.create",
															"visitsession.update");
		}

		public function api($method,$data) {

			if(!in_array($method,$this->get_requestlist()))
				throw new Exception("Some of the aliases you requested do not exist: ".$method, 1);
				
			$this->set_method($method);

			if(isset($data))
				$this->set_data($data);
			else
				throw new Exception("No data passed", 1);

			return $this->send($data);

		}

		public function send($data) {

			if(!$this->get_username() || !$this->get_password())
				throw new Exception("Username or Password not supplied", 1);

			if(!$this->get_method())
				throw new Exception("Method not supplied", 1);

			$data = http_build_query($data);

			$curl = curl_init($this->_host."/service/".$this->get_method());
			curl_setopt($curl,CURLOPT_CUSTOMREQUEST,"POST");
			curl_setopt($curl,CURLOPT_USERPWD, $this->get_username().":".$this->get_password());
			curl_setopt($curl,CURLOPT_HTTPAUTH,CURLAUTH_BASIC);
			curl_setopt($curl,CURLOPT_BINARYTRANSFER,true);
			curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($curl,CURLOPT_POST,true);				
			curl_setopt($curl,CURLOPT_POSTFIELDS,$data);

			$body = curl_exec($curl);

			if($this->is_debug()) 
				print_r("body: ".$body); 
			
			if($error_number=curl_errno($curl)) {
				$error_message = curl_error($curl);

				print_r($error_message);
				return "Error: ".$error_message." - ".$error_number;		
			}

			return json_decode($body);

		}




}


		

