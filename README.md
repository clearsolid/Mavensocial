Mavensocial
===========

The following list of Mavensocial API calls are supported with this class:

authtoken.get,
contact.create,
contact.get,
contact.getbyid,
contact.getcustomfields,
contact.getsharepurl,
contact.update,
contacts.bysite,
contacts.get,
contest.submit,
contest.vote,
contestentries.get,
contestentry.get,
order.track,
social.post_facebook,
social.post_twitter,
social.post_linkedin,
user.create,
user.delete,
user.get,
user.getsites,
user.modify,
visitsession.create,
visitsession.update,

Usage
===========
			$data = array("user_id"=>"3");

			try {
				$mavenapi_cmodel = MAVEN_API::create("users email","password")															->api("user.get",$data);
			} catch(Exception $e) {
				echo $e;
			}

