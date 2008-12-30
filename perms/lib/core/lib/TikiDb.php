<?php
require_once 'TikiDb/ErrorHandler.php';

class TikiDb
{
	private static $instance;

	private $errorHandler;
	private $errorMessage;
	private $serverType;

	protected $savedQuery;

	public static function get() // {{{
	{
		return self::$instance;
	} // }}}

	public static function set( TikiDb $instance ) // {{{
	{
		return self::$instance = $instance;
	} // }}}

	function startTimer() // {{{
	{
		list($micro, $sec) = explode(' ', microtime());
		return $micro + $sec;
	} // }}}

	function stopTimer($starttime) // {{{
	{
		global $elapsed_in_db;
		list($micro, $sec) = explode(' ', microtime());
		$now=$micro + $sec;
		$elapsed_in_db+=$now - $starttime;
	} // }}}

	function qstr( $str ) // {{{
	{
		return self::get()->qstr( $str );
	} // }}}

	function query( $query = null, $values = null, $numrows = -1, $offset = -1, $reporterrors = true ) // {{{
	{
		return self::get()->query( $query, $values, $numrows, $offset, $reporterrors );
	} // }}}

	function queryError( $query, &$error, $values = null, $numrows = -1, $offset = -1 ) // {{{
	{
		$result = $this->query( $query, $values, $numrows, $offset, false );
		$error = $this->errorMessage;

		return $result;
	} // }}}

	function getOne( $query, $values = null, $reporterrors = true, $offset = 0 ) // {{{
	{
		$result = $this->query( $query, $values, 1, $offset, $reporterrors );
		$res = $result->fetchRow();
		return reset( $res );
	} // }}}

	function setErrorHandler( TikiDb_ErrorHandler $handler ) // {{{
	{
		$this->errorHandler = $handler;
	} // }}}

	protected function getServerType() // {{{
	{
		return $this->serverType;
	} // }}}

	protected function setServerType( $type ) // {{{
	{
		$this->serverType = $type;
	} // }}}

	protected function getErrorMessage() // {{{
	{
		return $this->errorMessage;
	} // }}}

	protected function setErrorMessage( $message ) // {{{
	{
		$this->errorMessage = $message;
	} // }}}

	protected function handleQueryError( $query, $values, $result ) // {{{
	{
		if( $this->errorHandler )
			$this->errorHandler->handle( $this, $query, $values, $result );
		else {
			require_once 'TikiDb/Exception.php';
			throw new TikiDb_Exception( $this->getErrorMessage() );
		}
	} // }}}

	protected function convertQuery( &$query ) // {{{
	{
		switch ($this->serverType) {
			case "oci8":
				$query = preg_replace("/`/", "\"", $query);

				// convert bind variables - adodb does not do that
				$qe = explode("?", $query);
				$query = '';

				$temp_max = sizeof($qe) - 1;
				for ($i = 0; $i < $temp_max; $i++) {
					$query .= $qe[$i] . ":" . $i;
				}

				$query .= $qe[$i];
			break;

			case "postgres7":
			case "postgres8":
			case "sybase":
				$query = preg_replace("/`/", "\"", $query);
			break;

			case "mssql":
				$query = preg_replace("/`/","",$query);
				$query = preg_replace("/\?/","'?'",$query);
			break;

			case "sqlite":
				$query = preg_replace("/`/", "", $query);
			break;
		}
	} // }}}

	protected function convertQueryTablePrefixes( &$query ) // {{{
	{
		$db_table_prefix = isset($GLOBALS["db_table_prefix"])?$GLOBALS["db_table_prefix"]:'' ;
		$common_tiki_users = isset($GLOBALS["common_tiki_users"])?$GLOBALS["common_tiki_users"]:'';
		$common_users_table_prefix = isset($GLOBALS["common_users_table_prefix"])?$GLOBALS["common_users_table_prefix"]:'';

		if ( isset($db_table_prefix) && !is_null($db_table_prefix) && !empty($db_table_prefix) ) {

			if( isset($common_users_table_prefix) && !is_null($common_users_table_prefix) && !empty($common_users_table_prefix) ) {
				$query = str_replace("`users_", "`".$common_users_table_prefix."users_", $query);
			} else {
				$query = str_replace("`users_", "`".$db_table_prefix."users_", $query);
			}

			$query = str_replace("`tiki_", "`".$db_table_prefix."tiki_", $query);
			$query = str_replace("`messu_", "`".$db_table_prefix."messu_", $query);
			$query = str_replace("`sessions", "`".$db_table_prefix."sessions", $query);
			$query = str_replace("`galaxia_", "`".$db_table_prefix."galaxia_", $query);
		}
	} // }}}

	function convertSortMode( $sort_mode ) // {{{
	{
		if ( !$sort_mode ) {
			return '';
		}
		// parse $sort_mode for evil stuff
		$sort_mode = str_replace('pref:','',$sort_mode);
		$sort_mode = preg_replace('/[^A-Za-z_,.]/', '', $sort_mode);

		if ($sort_mode == 'random') {
			$map = array("postgres7" => "RANDOM()",
					"postgres8" => "RANDOM()",
					"mysql3" => "RAND()",
					"mysql" => "RAND()",
					"mysqli" => "RAND()",
					"mssql" => "NEWID()",
					"firebird" => "1", // does this exist in tiki?

					// below is still needed, return 1 just for not breaking query
					"oci8" => "1",
					"sqlite" => "1",
					"sybase" => "1");

			return $map[$this->serverType];
		}

		$sorts=explode(',', $sort_mode);
		foreach($sorts as $k => $sort) {

			// force ending to either _asc or _desc unless it's "random"
			$sep = strrpos($sort, '_');
			$dir = substr($sort, $sep);
			if (($dir !== '_asc') && ($dir !== '_desc')) {
				if ( $sep != (strlen($sort) - 1) ) {
					$sort .= '_';
				}
				$sort .= 'asc';
			}

			switch ($this->serverType) {
				case "postgres7":
					case "postgres8":
					case "oci8":
					case "sybase":
					case "mssql":
					$sort = preg_replace('/_asc$/', '" asc', $sort);
				$sort = preg_replace('/_desc$/', '" desc', $sort);
				$sort = '"' . $sort;
				break;

				case "sqlite":
					$sort = preg_replace('/_asc$/', ' asc', $sort);
				$sort = preg_replace('/_desc$/', ' desc', $sort);
				break;

				case "mysql3":
					case "mysql": 
					case "mysqli":
				default:
					$sort = preg_replace('/_asc$/', '` asc', $sort);
					$sort = preg_replace('/_desc$/', '` desc', $sort);
					$sort = '`' . $sort;
					$sort = str_replace('.', '`.`', $sort);
					break;
			}
			$sorts[$k]=$sort;
		}

		$sort_mode=implode(',', $sorts);
		return $sort_mode;
	} // }}}

	function convertBinary() // {{{
	{
		switch ($this->serverType) {
		case "oci8":
		case "postgres7":
		case "postgres8":
		case "sqlite":
			return;

		case "mysql3":
		case "mysql":
		case "mysqli":
			return "binary";
		}
	} // }}}
	
	function cast( $var,$type ) // {{{
	{
		switch ($this->serverType) {
		case "sybase":
			switch ($type) {
			case "int":
				return " CONVERT(numeric(14,0),$var) ";
			case "string":
				return " CONVERT(varchar(255),$var) ";
			case "float":
				return " CONVERT(numeric(10,5),$var) ";
			default:
				return($var);
			}

		default:
			return($var);
		}
	} // }}}

	function getQuery() // {{{
	{
		return $this->savedQuery;
	} // }}}

	function setQuery( $sql ) // {{{
	{
		$this->savedQuery = $sql;
	} // }}}

	function ifNull( $field, $ifNull ) // {{{
	{
		return " IFNULL($field, $ifNull) "; // if MySQL
	} // }}}

	function concat() // {{{
	{
		$arr = func_get_args();

		// suggestion by andrew005@mnogo.ru
		$s = implode(',',$arr);
		if (strlen($s) > 0) return "CONCAT($s)";
		else return '';
	} // }}}
}

?>
