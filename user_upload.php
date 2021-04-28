<?php
// store command line options
$shortopts = "u::p::h::";
$longopts  = array(
    "file::",
    "create_table",
    "dry_run",
    "help"
	);
$options = getopt($shortopts, $longopts);

// validate command line options
if (count($options) < 1) {
	output_message("No valid options found, one or more of the options below are required\n\n");
	show_help();
	exit;
}
if (isset($options['file']) && $options['file'] == false) {
	output_message("Error: file name must be specified\n");
	exit;
}
if (isset($options['dry-run']) && !isset($options['file'])) {
	output_message("Error: the --file option must be used in conjunction with --dry-run\n");
	exit;
}
if ((isset($options['u']) || isset($options['p']) || isset($options['h'])) && !(isset($options['u']) && isset($options['p']) && isset($options['h']))) {
	output_message("Error: database options -u, -p and -h must all be used together\n");
	exit;
}
if ((isset($options['create_table'])) && !(isset($options['u']) && isset($options['p']) && isset($options['h']))) {
	output_message("Error: database options -u, -p and -h are required with --create_table\n");
	exit;
}
if (isset($options['u']) && $options['u'] == false) {
	output_message("Error: DB username is empty\n");
	exit;
}
if (isset($options['p']) && $options['p'] == false) {
	output_message("Error: DB password is empty\n");
	exit;
}
if (isset($options['h']) && $options['h'] == false) {
	output_message("Error: DB hostname is empty\n");
	exit;
}

// process command line options
if (isset($options['help'])) {
	show_help();
	exit;
}
if (isset($options['create_table'])) {
	create_table();
	exit;
}

function output_message($message) {
	$out = fopen('php://output', 'w');
	fputs($out, $message);
}

function show_help() {
	$help_text = "--file [csv file name] – this is the name of the CSV to be parsed\n";
	$help_text .= "--create_table – this will cause the MySQL users table to be built (and no further action will be taken)\n";
	$help_text .= "--dry_run – this will be used with the --file directive in case we want to run the script but not insert into the DB. All other functions will be executed, but the database won't be altered\n";
	$help_text .= "-u – MySQL username\n";
	$help_text .= "-p – MySQL password\n";
	$help_text .= "-h – MySQL host\n";
	$help_text .= "--help – print this help\n";
	output_message($help_text);
}

function get_db_handle() {
	global $options;
	$dbh = mysqli_connect($options['h'], $options['u'], $options['p'], 'php-test-task');
	if (mysqli_connect_errno()) {
	    output_message("Database connection error: ".mysqli_connect_error()."\n");
	    exit;
	};
	return $dbh;
}

function create_table() {
	$dbh = get_db_handle();
	$sql = "CREATE TABLE `users` (
			  `name` varchar(255) NOT NULL,
			  `surname` varchar(255) NOT NULL,
			  `email` varchar(255) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	if (!mysqli_query($dbh, $sql)) {
		output_message("Database Error: ".mysqli_error($dbh)."\n");
		exit;
	}
	$sql = "ALTER TABLE `users`
			  ADD UNIQUE KEY `email` (`email`);";
	if (!mysqli_query($dbh, $sql)) {
		output_message("Database Error: ".mysqli_error($dbh)."\n");
		exit;
	}
	output_message("Database successfully created\n");	
}

?>