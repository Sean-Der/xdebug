--TEST--
Test computerized function traces (level4, comp, with return)
--INI--
xdebug.default_enable=1
xdebug.profiler_enable=0
xdebug.auto_trace=0
xdebug.trace_format=1
xdebug.dump_globals=0
xdebug.show_mem_delta=0
xdebug.collect_vars=0
xdebug.collect_params=4
xdebug.collect_return=1
xdebug.collect_assignments=0
xdebug.force_error_reporting=0
--FILE--
<?php
$tf = xdebug_start_trace('/tmp/'. uniqid('xdt', TRUE), XDEBUG_TRACE_COMPUTERIZED);

function foo( $a, $b )
{
	return $a;
}

$r = @foo( 42 );
$r = @foo( "string" );
$r = @foo( "string\nwi\th\nnewline" );
$r = @foo( 1, false );
$r = @foo( true, null );
$r = @foo( "foo", "bar", 3.1415 );

xdebug_stop_trace();
echo file_get_contents($tf);
unlink($tf);
?>
--EXPECTF--
Version: %s
File format: %d
TRACE START [%d-%d-%d %d:%d:%d]
2	2	1	%f	%d
2	3	0	%f	%d	foo	1		%sfunctrace_comp_4r.php	9	2	$a = 42	$b = ???
2	3	1	%f	%d
2	3	R			42
2	4	0	%f	%d	foo	1		%sfunctrace_comp_4r.php	10	2	$a = 'string'	$b = ???
2	4	1	%f	%d
2	4	R			'string'
2	5	0	%f	%d	foo	1		%sfunctrace_comp_4r.php	11	2	$a = 'string\nwi\th\nnewline'	$b = ???
2	5	1	%f	%d
2	5	R			'string\nwi\th\nnewline'
2	6	0	%f	%d	foo	1		%sfunctrace_comp_4r.php	12	2	$a = 1	$b = FALSE
2	6	1	%f	%d
2	6	R			1
2	7	0	%f	%d	foo	1		%sfunctrace_comp_4r.php	13	2	$a = TRUE	$b = NULL
2	7	1	%f	%d
2	7	R			TRUE
2	8	0	%f	%d	foo	1		%sfunctrace_comp_4r.php	14	3	$a = 'foo'	$b = 'bar'	3.1415
2	8	1	%f	%d
2	8	R			'foo'
2	9	0	%f	%d	xdebug_stop_trace	0		%sfunctrace_comp_4r.php	16	0
			%f	%d
TRACE END   [%d-%d-%d %d:%d:%d]
