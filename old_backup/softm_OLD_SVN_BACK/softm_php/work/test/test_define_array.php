<?php
Define(
		'_TESTARRAYCONSTANT',
		serialize (
				array(
						'1'  => 'the value is 1',
						'10' => 'the vaue is 10',
						'100' => 'the value is 100',
						'1000' => 'the value is 1000'
				)
		)
);
 
$testDefine = unserialize(_TESTARRAYCONSTANT);

print_r(_TESTARRAYCONSTANT);
echo $testDefine["10"];
print '<BR /><BR />';

print $testDefine[10];
print '<BR />';
print $testDefine[1000];
?>