<?

//include the cache class
include 'cache.class.php';

$cache = new Cache;
$cache->setKey('cachedContent');
$cache->setTime(60 * 60 * 24);

//delete cache if debuggin is set to true
if(isset($_GET['debug']) && (intval($_GET['debug']) == 1)){
	$cache->deleteCache();
}

//check for the cached file and set the cached array if exists
if($cache->checkCache()){ 
	$cacheArr = $cache->getCache();
}

//if the cached array exists set the HTML, else create the new HTML and save this to the cache file
if(isset($cacheArr)){
	$demoHTML = $cacheArr['data'];
	$demoHTML .= '<!-- cached at ' . $cacheArr['time'] . '-->';
} else {

	$demoHTML = '<div class="demo-wrapper">
		<h1>Title of the content</h1>
		<p>This is some content!</p>
	</div>';

	$cache->setHTML($demoHTML);
	$cache->setCache();

}

echo $demoHTML;

//unset the cache
unset($cache);

?>