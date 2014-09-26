<?php 
class ReqLog {
  private $ip;
  private $browser_ua;

  public function __construct($tag = 'log') {

    // get IP
    $this->ip = $_SERVER['REMOTE_ADDR'];

    // if HTTP_X_FORWARDED_FOR is set save it too
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $http_forwarded = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      // set to something
      $http_forwarded = 'null';
    }

    // save browser user agent string
    $this->browser_ua = $_SERVER['HTTP_USER_AGENT'];

    // get database connection or create a new one
    $database = SimplePDO::getInstance();

    // insert in database
    $database->query("INSERT INTO `requests` (ip, http_forwared, browser_ua, tag) VALUES (:ip, :http_forwared, :browser_ua, :tag)");
    $database->bind(':ip', $this->ip);
    $database->bind(':http_forwared', $http_forwarded);
    $database->bind(':browser_ua', $this->browser_ua);
    $database->bind(':tag', $tag);
    $database->execute();
  }

  public function num_visits() {
    $database = SimplePDO::getInstance();

    // count numbers of rows that has equal ip and UA string
    $database->query("SELECT * FROM `requests` WHERE `ip` = :ip AND `browser_ua` = :browser_ua");
    $database->bind(':ip', $this->ip);
    $database->bind(':browser_ua', $this->browser_ua);
    $database->execute();

    return $database->rowCount();
  }

  public function num_ip_visits() {
    $database = SimplePDO::getInstance();

    // count numbers of rows that has equal ip
    $database->query("SELECT * FROM `requests` WHERE `ip` = :ip");
    $database->bind(':ip', $this->ip);
    $database->execute();

    return $database->rowCount();
  }

  public function this_browser_percent() {
    $database = SimplePDO::getInstance();
    // count all requests
    $database->query("SELECT * FROM `requests`");
    $database->execute();
    $total = $database->rowCount();

    // count all requests with current ua string
    $database->query("SELECT * FROM `requests` WHERE `browser_ua` = :browser_ua");
    $database->bind(':browser_ua', $this->browser_ua);
    $database->execute();
    $this_browser = $database->rowCount();

    // return this browser usage in percent
    return $this_browser / $total * 100;
  }
}
