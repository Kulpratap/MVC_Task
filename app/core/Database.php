<?php
namespace app\core;
trait Database
{
  /** @var string */
  private $servername;
  /** @var string */
  private $username;
  /** @var string */
  private $password;
  /** @var string */
  private $dbname;
  /** @var \mysqli */
  private $conn;

  /**
   * Constructor to initialize database connection parameters.
   *
   * @param string $servername
   *   The server name.
   * @param string $username
   *   The username.
   * @param string $password
   *   The password.
   * @param string $dbname
   *   The database name.
   */
  public function connection($servername, $username, $password, $dbname)
  {
    $this->servername = $servername;
    $this->username = $username;
    $this->password = $password;
    $this->dbname = $dbname;

    // Create connection
    $this->conn = new \mysqli($this->servername, $this->username, $this->password, $this->dbname);

    // Check connection
    if ($this->conn->connect_error) {
      die("Connection failed: " . $this->conn->connect_error);
    }
  }
  public function closeConnection()
  {
    $this->conn->close();
  }
}
