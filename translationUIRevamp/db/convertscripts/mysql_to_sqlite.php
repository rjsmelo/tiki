<?php

	require 'tikiversion.php';

	class SQL_Script_Mapper
	{
		const STATEMENT_TYPE_CREATE_TABLE='CREATE TABLE';
		const STATEMENT_TYPE_DROP_TABLE='DROP TABLE';
		const STATEMENT_TYPE_INSERT_INTO='INSERT INTO';
		const STATEMENT_TYPE_INSERT_IGNORE_INTO='INSERT IGNORE INTO';
		const STATEMENT_TYPE_UPDATE='UPDATE';
		const STATEMENT_TYPE_CREATE_INDEX='CREATE INDEX';
		const STATEMENT_TYPE_ALTER_TABLE='ALTER TABLE';
		
		private $statements;
		
		public function convertMysqlToSqlite($filename)
		{
			$data = file_get_contents($filename);
			$data = preg_replace('/\-\-.*\n/', '', $data);
			$this->statements = preg_split('/;\n/', $data);
			echo count($this->statements)." statements\n";
			foreach ($this->statements as $key=>$statement) {
				$this->statements[$key] = $this->convertStatement(trim($statement));
			}
			return implode(";\n", $this->statements);
		}
		
		private function convertStatement($statement)
		{
			if (substr($statement, 0, 2)=='--') {
				// comment, do nothing
			} else if (substr($statement, 0, strlen(self::STATEMENT_TYPE_CREATE_TABLE))==self::STATEMENT_TYPE_CREATE_TABLE) {
				return $this->convertStatementCreateTable($statement);
			} else if (substr($statement, 0, strlen(self::STATEMENT_TYPE_DROP_TABLE))==self::STATEMENT_TYPE_DROP_TABLE) {
				return $this->convertStatementDropTable($statement);
			} else if (substr($statement, 0, strlen(self::STATEMENT_TYPE_INSERT_INTO))==self::STATEMENT_TYPE_INSERT_INTO) {
				return $this->convertStatementInsertInto($statement);
			} else if (substr($statement, 0, strlen(self::STATEMENT_TYPE_INSERT_IGNORE_INTO))==self::STATEMENT_TYPE_INSERT_IGNORE_INTO) {
				return $this->convertStatementInsertIgnoreInto($statement);
			} else if (substr($statement, 0, strlen(self::STATEMENT_TYPE_UPDATE))==self::STATEMENT_TYPE_UPDATE) {
				return $this->convertStatementUpdate($statement);
			} else if (substr($statement, 0, strlen(self::STATEMENT_TYPE_CREATE_INDEX))==self::STATEMENT_TYPE_CREATE_INDEX) {
				return $this->convertStatementUpdate($statement);
			} else if (substr($statement, 0, strlen(self::STATEMENT_TYPE_ALTER_TABLE))==self::STATEMENT_TYPE_ALTER_TABLE) {
				return $this->convertStatementUpdate($statement);
			} else {
				echo 'Unknown statement type: '.$statement."\n";
			}
		}
		
		private function convertStatementDropTable($statement)
		{
			return $statement;
		}
		private function convertStatementCreateTable($statement)
		{
			//TODO implement
			
			// remove ENGINE
			$statement = preg_replace('/ENGINE=[a-zA-Z0-9]*/', '', $statement);
			// remove table constraint AUTO_INCREMENT
			$statement = preg_replace('/AUTO_INCREMENT=[0-9]+/', '', $statement);
			// remove column constraint auto_increment – TODO make it AUTOINCREMENT (needs it to be PRIMARY KEY, as column constraint, defined as such right in line)
			$statement = preg_replace('/(,)?\n(.*)auto_increment(,)?\n/', "\n$1$2$3\n", $statement);
			//$statement = preg_replace('/\n(.*)(PRIMARY KEY )auto_increment(,)?\n/', "\n$1$2 AUTOINCREMENT$3\n", $statement);
			//$statement = preg_replace('/\n(.*)(?!PRIMARY KEY )auto_increment(,)?\n/', "\n$1$3\n", $statement);
			// remove table KEYs
			$statement = preg_replace('/(,)?\n([ \t]*)(FULLTEXT )?KEY [a-zA-Z0-9`]* \([a-zA-Z0-9`\(\), ]*\),?/', "\n$2\n", $statement);
			// remove column types unsigned
			$statement = preg_replace('/(,)?\n(.*)unsigned(.)*(,)?\n/', "$1\n$2$3$4\n", $statement);
			
			// UNIQUE KEY `catname` (`calendarId`, `name`(16)) --> CONSTRAINT name UNIQUE ( index col, icol )
			//FIXME does not work, drops it entirely
			$statement = preg_replace('/UNIQUE KEY ([a-zA-Z0-9`]+) \((.*)\)/e', '$this->convertColumnDefinition("$2", "CONSTRAINT $1 UNIQUE ( ", " )");', $statement); 

			return $statement;
		}
		private function convertStatementInsertInto($statement)
		{
			//TODO implement
			return $statement;
		}
		private function convertStatementInsertIgnoreInto($statement)
		{
			//TODO implement
			return $statement;
		}
		private function convertStatementUpdate($statement)
		{
			//TODO implement
			return $statement;
		}
		
		private function convertColumnDefinition($colDef)
		{
			
		}
		private function convertColumnList($str, $pre='', $post='')
		{
			return $pre.preg_replace('/([a-zA-Z0-9`]+)\(.*\)( ?, ?[a-zA-Z0-9`]+\(.*\))*/', '$1$2', $str).$post;
		}
		
	}

	$map = new SQL_Script_Mapper();
	$converted = $map->convertMysqlToSqlite('../tiki.sql');
	file_put_contents($tikiversion.'.to_sqlite.sql', $converted);


//// Set tikiversion variable
//if(!isset($_GET['version'])) {
//	require 'tikiversion.php';
//	echo "version not given. Using default $tikiversion.<br />";
//} else {
//	if (preg_match('/\d\.\d/',$_GET['version'])) {
//		$tikiversion=$_GET['version'];
//	}
//}
//
//
//$data = file_get_contents('../tiki.sql');
//echo "<br />\n";
//
//// remove ENGINE
//$data = preg_replace('/ENGINE=[a-zA-Z0-9]*/', '', $data);
//
//// remove table AUTO_INCREMENT
//$data = preg_replace('/AUTO_INCREMENT=[0-9]+/', '', $data);
//
//// remove column auto_increment
//$data = preg_replace('/(,)?\n(.*)auto_increment(,)?\n/', "\n$1$2$3\n", $data);
////$data = preg_replace('/\n(.*)(PRIMARY KEY )auto_increment(,)?\n/', "\n$1$2 AUTOINCREMENT$3\n", $data);
////$data = preg_replace('/\n(.*)(?!PRIMARY KEY )auto_increment(,)?\n/', "\n$1$3\n", $data);
//
//// remove table KEYs
//$data = preg_replace('/(,)?\n([ \t]*)(FULLTEXT )?KEY [a-zA-Z0-9`]* \([a-zA-Z0-9`\(\), ]*\),?/', "\n$2\n", $data);
//
//// remove column types unsigned
//$data = preg_replace('/(,)?\n(.*)unsigned(.)*(,)?\n/', "$1\n$2$3$4\n", $data);
//
//$data = preg_replace('/,([\n \t]*)\)(.*);/', '$1)$2;', $data);
//
//
//
//
////$data = preg_replace('/,([\n \t]*)\),/', '', $data);
////$data = preg_replace('/\n([ \t]*)\),([ \t]*)\)\n/', '', $data);
//
////$data = preg_replace('/\n[ \t]*\n/', '', $data);
////$data = preg_replace('/\n/', '', $data);
////$data = preg_replace('/(CREATE TABLE [`a-zA-Z0-9]* )\((.*)\)(.*);/', '$1$2$3', $data);
//
//// save file
//file_put_contents($tikiversion.'.to_sqlite.sql', $data);

?>