<?php
/**
 * Login & Session Management
 *
 * Use:
 * Include Script on any page with elements requireing permissions
 * and on logon page.
 * Use "if($sessionUser->logedin)" to hide information on pages.
 *
 *
 * Notes on Security:
 * This script was made with the intent of being as secure as posible
 * without using SSL. Because of this some issues may occur with
 * certian users. Users whos browsers user agent switches between pages
 * thoes who switch computers/browsers often will be loged off. In both
 * cases if the user has selected 'remember me' they will immediately be
 * loged back in and there should not be an issue.
 *
 * Despite my best efforts it is a fact of life that cookies are ment to
 * be eaten. Here are the only known atack plans that would work on this
 * system. First an atacker would have to steal the users cookies for the
 * site. Then switch his user agent to that of the users. After this he
 * has 2 options: 
 * a) Use the PHP Session cookie and do his deeds before the user logs out
 *    or he or the user gets a new session id (~5 requests).
 * b) Wait for the user to leave the site but not log off. Then use the
 * ID and Tolken cookies.
 * For both situations if the user had not left the atacker would be
 * kicked off and a 'You have loged on from another location' message can
 * be issued to warn the user.
 *
 * There are two other Atacks which i believe could work but I am too
 * lazy to test them and the only upshot would be that the ataker
 * would recieve a new cookie that the user does not have. Therefore would
 * work untill the user logs back in with 'remember me' checked. Because
 * of the complexity of these atacks there is no obviouse way for me to fix
 * them.
 * C - Fixed) To set up the atacker would login with a known username and 
 * password then kick himself off the system by logging in with a different
 * browser. He would then insert the victims cookies into the first browser
 * and refresh. Because his session cookie is invalid, logedOut will = true
 * and cookieLogin() will be called to re-authenticate. Since the user cookie
 * is valid and logedout is true, a new cookie will be issued and the other
 * made invalid.
 * D) Much like C), an atacker would cause a log off to be called using 2
 * separate browsers. The only difference being that the first would be
 * loged on using the users cookie as well. This makes $this->UID = the
 * victims ID instead of the atackers, validating the query.
 *
 *
 * Notes on 'Remember Me'
 * The 'remember me' feature only alows for it to be used on one
 * computer/browser at a time and will work on the one most recently used.
 * A user can be loged in in more than one place if both are not activly
 * used. For example if one computer has remember me on and another does
 * not, the computer without will be alowed to remain loged in untill the
 * remembered computer becomes active. If two computers use remember me
 * only the most recent will be. 'Remember me' last 7 days.
 *
 *
 * @author     Neil Vallon <neilvallon@gmail.com>
 * @copyright  2011
 */
require_once('functions.php');
$sessionUser = new sessionManager;

class sessionManager{
	public $logedin, $logedOut, $UID, $output;

	function __construct(){
		session_start();
		if(isset($_SESSION['UID']) && $this->UID = $_SESSION['UID']) $this->validateSession();
		if(!$this->logedin && $this->cookieLogin()) $this->logedin = true;
	}

	function __destruct() {
		echo $this->output;	
	}


	function validateSession(){
		$this->updateSessionID();

		if($this->initialUser()){
			$this->logedin = true;
		}else{
			$this->softLogout();
			$this->output .=  "You have loged in from another location<br />";
		}
	}


	function initialUser(){
		if(isset($_SESSION['initSessionToken'])
		&& $_SESSION['agent'] == md5($_SERVER['HTTP_USER_AGENT']) //Will more than likely not change if same user
		&& query("SELECT * FROM testUsers WHERE UID='%s' AND initSessionToken='%s'", $_SESSION['UID'], $_SESSION['initSessionToken']))
			return mysql_affected_rows(); 
	}


	function softLogout(){
		$this->logedOut = true;
		$this->logedin = false;
		unset($_SESSION);
		session_destroy();
		session_start();
	}


	function logout(){
		$this->softLogout();
		if($this->UID) query("UPDATE testUsers SET initSessionToken='%s' WHERE UID='%s'", '', $this->UID);
		if(isset($_COOKIE['remCookie'])){
			setcookie('remCookie[ID]', '', time()-3600, '/');
			setcookie('remCookie[Token]', '', time()-3600, '/');
		}
		$this->output .=  "You have been loged out<br />";
	}


	function login($email, $pass, $rem){
		if($this->logedin) return; //What are you doing? Your already loged in
		require_once('PasswordHash.php');
		$hasher = new PasswordHash(8, false);
		$result = query("SELECT UID, User_Password FROM testUsers WHERE User_email='%s'", $email);
		$result = mysql_fetch_array($result, MYSQL_ASSOC);

		if(mysql_affected_rows())
			query("UPDATE testUsers SET User_LastLogin='%s', User_LoginIP='%s', User_Agent='%s' WHERE User_email='%s'",
				date('c'), $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], $email);

		if($hasher->CheckPassword($pass, $result['User_Password'])){
			$_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);
			$this->UID = $_SESSION['UID'] = $result['UID'];
			$this->updateSessionID();
			if($rem) $this->setCookieToken();
			$this->logedin = true;
			$this->output .=  "Login Successfull<br />";
			return true;
		}
		$this->output .=  "Invalid Username or Password<br />";
	}


	function cookieLogin(){
		if(isset($_COOKIE['remCookie']['ID']) && isset($_COOKIE['remCookie']['Token'])){
			if(!$this->logedOut) $this->UID = $_SESSION['UID'] = $_COOKIE['remCookie']['ID']; //Prevents attack C)
			
			query("SELECT * FROM testUsers WHERE UID='%s' AND cookieToken='%s'", $this->UID, $_COOKIE['remCookie']['Token']);	
			if(mysql_affected_rows()){
				if($this->logedOut) $this->setCookieToken(); //Prevents an atacker from using the same cookie twice
				$_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);
				$this->updateSessionID();
				
				return true;
			}else $this->logout(); //mainly used to delete cookies
		}
	}


	function updateSessionID(){
		if(!isset($_SESSION['lastRegeneration']) or ++$_SESSION['lastRegeneration'] > 5){ //Swaps session every 5 checks
			$_SESSION['lastRegeneration'] = 0;
			$_SESSION['initSessionToken'] = session_id();
			session_regenerate_id();
			query("UPDATE testUsers SET initSessionToken='%s' WHERE UID='%s'", $_SESSION['initSessionToken'], $this->UID);
		}
	}


	function setCookieToken(){
		$newToken = hash('sha256', time().COOKIE_SALT);
		query("UPDATE testUsers SET cookieToken='%s' WHERE UID='%s'", $newToken, $this->UID);
		setcookie("remCookie[ID]", $this->UID, COOKIE_EXPIRE, '/', null, null, true);
		setcookie("remCookie[Token]", $newToken, COOKIE_EXPIRE, '/', null, null, true);
	}


}
?>