<?php
echo "<?php\n";
echo "App::uses('{$plugin}AppController', '{$pluginPath}Controller');\n";
?>
/**
 * <?php echo $controllerName; ?> Controller
 *
<?php
if (!$isScaffold) {
	$defaultModel = Inflector::singularize($controllerName);
	echo " * @property {$defaultModel} \${$defaultModel}\n";
	if (!empty($components)) {
		foreach ($components as $component) {
			echo " * @property {$component}Component \${$component}\n";
		}
	}
}
?>
 */
class <?php echo $controllerName; ?>Controller extends <?php echo $plugin; ?>AppController {

/**
 *  Layout
 *
 * @var string
 */
	public $layout = 'bootstrap';

<?php if ($isScaffold): ?>
/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;
<?php else: ?>
<?php
if (!is_array($helpers)) {
	$helpers = array();
}
$helpers += array(
	'Session',
	'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
	'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
	'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator')
);
if (count($helpers)):
	echo "/**\n * Helpers\n *\n * @var array\n */\n";
	echo "\tpublic \$helpers = array(";
	$out = '';
	foreach ($helpers as $helper => $options):
		// if not integer then associative
		if (!is_integer($helper)) {
			$out .= var_export(Inflector::camelize($helper),true);
			$out .= " => " . var_export($options,true);
		}
		else if (is_integer($helper)) {
			$out .= var_export(Inflector::camelize($options),true);
		}
		$out .= ",";
	endforeach;
	$out = rtrim($out,',') . ");\n";

	echo $out;
endif;

if (!is_array($components)) {
	$components = array();
}
$components += array('Session');
if (count($components)):
	echo "/**\n * Components\n *\n * @var array\n */\n";
	echo "\tpublic \$components = array(";
	for ($i = 0, $len = count($components); $i < $len; $i++):
		if ($i != $len - 1):
			echo "'" . Inflector::camelize($components[$i]) . "', ";
		else:
			echo "'" . Inflector::camelize($components[$i]) . "'";
		endif;
	endfor;
		echo ");\n\n";
endif;

	echo trim($actions) . "\n";

endif; ?>
}
