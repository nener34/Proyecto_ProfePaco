<?php require_once('../Connections/Conectar4.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if ((isset($_GET['eliminar'])) && ($_GET['eliminar'] != "")) {
  $deleteSQL = sprintf("DELETE FROM doperadores WHERE id_ope=%s",
                       GetSQLValueString($_GET['eliminar'], "int"));

  mysql_select_db($database_Conectar4, $Conectar4);
  $Result1 = mysql_query($deleteSQL, $Conectar4) or die(mysql_error());

  $deleteGoTo = "consulta-ope.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['B'])) {
  $colname_Recordset1 = $_GET['B'];
}
mysql_select_db($database_Conectar4, $Conectar4);
$query_Recordset1 = sprintf("SELECT * FROM doperadores WHERE id_ope = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $Conectar4) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<h2>ELIMINAR OPERADOR</h2>
<table width="515" height="223" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="263">Id</td>
    <td width="246"><?php echo $row_Recordset1['id_ope']; ?></td>
  </tr>
  <tr>
    <td>Clave del operador</td>
    <td><?php echo $row_Recordset1['clav_ope']; ?></td>
  </tr>
  <tr>
    <td>Nombre</td>
    <td><?php echo $row_Recordset1['nom_ope']; ?></td>
  </tr>
  <tr>
    <td>Apellido paterno</td>
    <td><?php echo $row_Recordset1['apap_ope']; ?></td>
  </tr>
  <tr>
    <td>Apellido materno</td>
    <td><?php echo $row_Recordset1['apem_ope']; ?></td>
  </tr>
  <tr>
    <td><form name="form1" method="get" action="">
      <input name="eliminar" type="hidden" id="eliminar" value="<?php echo $row_Recordset1['id_ope']; ?>">
      <input type="submit" name="button" id="button" value="Eliminar Operador">
    </form></td>
    <td><form name="form2" method="post" action="consulta-ope.php">
      <input type="submit" name="button2" id="button2" value="Cancelar">
    </form></td>
  </tr>
</table>
<p>&nbsp;</p>
<?php
mysql_free_result($Recordset1);
?>
