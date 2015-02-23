<!DOCTYPE html>
<html>
<head>
  <title>LDAP Test connection</title>
</head>
<body>
  <h1>LDAP Test connection</h1>
</body>

<?php
include_once("config.php");
global $CONFIG_LDAP_SERVER, $CONFIG_LDAP_USER, $CONFIG_LDAP_PASS, $CONFIG_LDAP_BASE_DN;
  
  if (isset($_POST["ldaprdn"]) && isset($_POST["ldappass"]))
  {
  $ds=ldap_connect($CONFIG_LDAP_SERVER);

  if ($ds) 
  { 
      $r=ldap_bind($ds, $CONFIG_LDAP_USER, $CONFIG_LDAP_PASS);     
      $sr=ldap_search($ds, $CONFIG_LDAP_BASE_DN, "userPrincipalName=" . $_POST["ldaprdn"]);
      $info = ldap_get_entries($ds, $sr);

      for ($i=0; $i<$info["count"]; $i++) 
      {
          echo "NAME entry is: " . $info[$i]["givenname"][0] . "<br />";
          echo "EMAIL entry is: " . $info[$i]["userprincipalname"][0] . "<br /><hr />";
      }

      /*  
      echo '<pre>';
      var_dump($info);
      echo '</pre>';
      */

      ldap_close($ds);

  } 
      else 
      {
          echo "<h4>Unable to connect to LDAP server</h4>";
      }
  }
?>

  <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <label for="username">Username: </label><input id="ldaprdn" type="text" name="ldaprdn" /> 
    <label for="password">Password: </label><input id="ldappass" type="password" name="ldappass" />        
    <input type="submit" name="submit" value="Submit" />
  </form>