<?php
$xhtml = '<h1>CNav</h1>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Neue Instanz</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$theObj = new CNav(2, 'neuigkeiten', 'Neuigkeiten', null, array(53, 14));

$xhtml .= '<pre><code>'."\n";
$xhtml .= print_r($theObj, true);
$xhtml .= '</code></pre>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['xhtml'] = $xhtml;
return new CTemplateData($data, true);
?>