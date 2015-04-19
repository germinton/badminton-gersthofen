<?php
$xhtml = '';
$StrOK = '<span style="color:green">OK</span>';
$StrERR = '<span style="color:red">ERROR</span>';
$AlignL = 'style="text-align:left"';
$AlignR = 'style="text-align:right"';

function CheckAttachments($Attachmentbezeichnung, $Tabname)
{
	$IDName = S2S_TabName_IDName($Tabname);

	$StrOK = '<span style="color:green">OK</span>';
	$StrERR = '<span style="color:red">ERROR</span>';
	$AlignL = 'style="text-align:left"';
	$AlignR = 'style="text-align:right"';
	$xhtml = '';

	$xhtml .= '<table>'.PHP_EOL;
	$xhtml .= '<thead>'.PHP_EOL;
	$xhtml .= '<tr>'.PHP_EOL;
	$xhtml .= '<th '.$AlignL.'>Name</th>'.PHP_EOL;
	$xhtml .= '<th>AType</th>'.PHP_EOL;
	$xhtml .= '<th>Größe</th>'.PHP_EOL;
	$xhtml .= '<th>SVerhältnis</th>'.PHP_EOL;
	$xhtml .= '<th>Datensatz</th>'.PHP_EOL;
	$xhtml .= '</tr>'.PHP_EOL;
	$xhtml .= '</thead>'.PHP_EOL;
	$xhtml .= '<tbody>'.PHP_EOL;
	$dateien = scandir(DIR_ATTACHMENTS.'/'.$Tabname);

	$FileHasDBEntry = false;
	$PicWithinLimits = false;

	$sum_filesize = 0;

	foreach($dateien as $i => $datei)
	{
		if($i > 1) //ignoriere "." und ".."
		{
			$xhtml .= '<tr class="'.(($i%2)?('even'):('odd')).'">';

			// Dateiname
			$xhtml .= '<td '.$AlignL.'>'.$datei.'</td>'.PHP_EOL;

			// AttachType
			$AttachType = CUploadHandler::getAttachTypeForFilename($datei);
			$xhtml .= '<td>'.(($s = C2S_AttachType($AttachType))?($s):($StrERR)).'</td>'.PHP_EOL;

			$sum_filesize += $filesize = filesize(DIR_ATTACHMENTS.'/'.$Tabname.'/'.$datei);

			// Dateigröße OK?
			$xhtml .= '<td '.$AlignR.'>';
			if($AttachType)
			{
				$SizeExceeded = true;
				switch($AttachType)
				{
					case ATTACH_PIC: $SizeExceeded = ($filesize > MAX_FILE_SIZE_ATTACH_PIC); break;
					case ATTACH_FILE1:
					case ATTACH_FILE2:
					case ATTACH_FILE3: $SizeExceeded = ($filesize > MAX_FILE_SIZE_ATTACH_FILE); break;
					default: break;
				}
					
				$xhtml .= '<span style="color:'.(($SizeExceeded)?('red'):('green')).'">';
				$xhtml .= sprintf('%01.2f', round(($filesize/1024), 2)).'</span>&#x202F;KiB';
			}
			else {$xhtml .= $StrERR;}
			$xhtml .= '</td>'.PHP_EOL;

			// Seitenverhältnis?
			$xhtml .= '<td>';
			if(ATTACH_PIC == $AttachType)
			{
				$RatioExceeded = true;
				$Min = MAX_IMG_RATIO_SMLPART / MAX_IMG_RATIO_BIGPART;
				$Max = MAX_IMG_RATIO_BIGPART / MAX_IMG_RATIO_SMLPART;
				list($width, $height) = getimagesize(DIR_ATTACHMENTS.'/'.$Tabname.'/'.$datei);
				$Ration = $width / $height;
				$RatioExceeded = (($Ration < $Min) or ($Ration > $Max));
				$xhtml .= '<span style="color:'.(($RatioExceeded)?('red'):('green')).'">';
				$xhtml .= sprintf('%01.2f', round(($Ration), 2)).'</span>';

			}
			else if(!is_null($AttachType)) {$xhtml .= 'N/A';}
			else {$xhtml .= $StrERR;}
			$xhtml .= '</td>'.PHP_EOL;

			// Datenbankeintrag vorhanden?
			$xhtml .= '<td>';
			if($AttachType)
			{
				$FileHasDBEntry = true;
				$query = 'SELECT * FROM '.$Tabname.' WHERE '.$IDName.'='.substr($datei, 0, 10);
				if(!$result = mysql_query($query)) {throw new Exception(mysql_error(CDBConnection::getDB()));}
				if(!mysql_fetch_row($result)) {$FileHasDBEntry = false;}
				$xhtml .= '<span style="color:'.(($FileHasDBEntry)?('green'):('red')).'">';
				$xhtml .= '&#x2714;</span>';
			}
			else {$xhtml .= $StrERR;}
			$xhtml .= '</td>'.PHP_EOL;
				
			$xhtml .= '</tr>';
		}
	}
	$xhtml .= '</tbody>'.PHP_EOL;
	$xhtml .= '</table>'.PHP_EOL;

	return $xhtml;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Compliance-Regeln</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= '<table>'."\n";
$xhtml .= '<thead>'.PHP_EOL;
$xhtml .= '<tr>'.PHP_EOL;
$xhtml .= '<th '.$AlignL.'>Erklärung</th>'.PHP_EOL;
$xhtml .= '<th '.$AlignL.'>Konstante</th>'.PHP_EOL;
$xhtml .= '<th>Wert</th>'.PHP_EOL;
$xhtml .= '</tr>'.PHP_EOL;
$xhtml .= '</thead>'.PHP_EOL;
$xhtml .= '<tbody>'.PHP_EOL;
$xhtml .= '<tr class="special2">'.PHP_EOL;
$xhtml .= '<td '.$AlignL.'>Maximale Bilddimension (Breite oder Höhe)</td>'.PHP_EOL;
$xhtml .= '<td '.$AlignL.'>MAX_IMG_DIM</td>'.PHP_EOL;
$xhtml .= '<td>'.MAX_IMG_DIM.'</td>'.PHP_EOL;
$xhtml .= '</tr>'.PHP_EOL;
$xhtml .= '<tr class="special">'.PHP_EOL;
$xhtml .= '<td '.$AlignL.'>Seitenverhältnis: größerer Ganzzahlanteil</td>'.PHP_EOL;
$xhtml .= '<td '.$AlignL.'>MAX_IMG_RATIO_BIGPART</td>'.PHP_EOL;
$xhtml .= '<td>'.MAX_IMG_RATIO_BIGPART.'</td>'.PHP_EOL;
$xhtml .= '</tr>'.PHP_EOL;
$xhtml .= '<tr class="special2">'.PHP_EOL;
$xhtml .= '<td '.$AlignL.'>Seitenverhältnis: kleinerer Ganzzahlanteil</td>'.PHP_EOL;
$xhtml .= '<td '.$AlignL.'>MAX_IMG_RATIO_SMLPART</td>'.PHP_EOL;
$xhtml .= '<td>'.MAX_IMG_RATIO_SMLPART.'</td>'.PHP_EOL;
$xhtml .= '</tr>'.PHP_EOL;
$xhtml .= '<tr class="special">'.PHP_EOL;
$xhtml .= '<td '.$AlignL.'>Maximalgröße des Bildanhangs</td>'.PHP_EOL;
$xhtml .= '<td '.$AlignL.'>MAX_FILE_SIZE_ATTACH_PIC</td>'.PHP_EOL;
$xhtml .= '<td>'.(MAX_FILE_SIZE_ATTACH_PIC/1024).'&#x202F;KiB</td>'.PHP_EOL;
$xhtml .= '</tr>'.PHP_EOL;
$xhtml .= '<tr class="special2">'.PHP_EOL;
$xhtml .= '<td '.$AlignL.'>Maximalgröße des allgemeinen Dateianhangs</td>'.PHP_EOL;
$xhtml .= '<td '.$AlignL.'>MAX_FILE_SIZE_ATTACH_FILE</td>'.PHP_EOL;
$xhtml .= '<td>'.(MAX_FILE_SIZE_ATTACH_FILE/1024).'&#x202F;KiB</td>'.PHP_EOL;
$xhtml .= '</tr>'.PHP_EOL;
$xhtml .= '</tbody>'.PHP_EOL;
$xhtml .= '</table>'."\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Athleten</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= CheckAttachments('Athletenattachments', 'athleten');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Austragungsorte</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= CheckAttachments('Austragungsortattachments', 'austragungsorte');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Mannschaften</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= CheckAttachments('Mannschaftsattachments', 'mannschaften');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Neuigkeiten</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= CheckAttachments('Neuigkeitenattachments', 'neuigkeiten');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Termine</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= CheckAttachments('Terminattachments', 'termine');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhtml .= '<h2>Vereine</h2>'."\n";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xhtml .= CheckAttachments('Vereinsattachments', 'vereine');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Auswertung
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$heading = '<h1>Selbsttest der Attachments</h1>'.PHP_EOL;
$xhtml = $heading.'<p class="textbox schattiert"><em>Status '.
((strpos($xhtml, 'color:red'))?($StrERR):($StrOK)).'</em></p>'.PHP_EOL.$xhtml;

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['xhtml'] = $xhtml;
return new CTemplateData($data, true);
?>