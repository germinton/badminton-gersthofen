<?php $GalerieArray = $data['galerie_array'];
	  $Galerieeintrag = $data['galerieeintrag'];
?>
    <script type="text/javascript">
    /* <![CDATA[ */
        var mygroup = new Array();
<?php
        if(count($GalerieArray))
    	{
    		$y = 0;
    		$j = 0;
    		$yearsArray[] = array();
    		$currentYear = 3000;
    		foreach ($GalerieArray as $i => $Eintrag)
    		{
    			$year = substr($Eintrag->getDatum(),0,4);
    			//echo $cDate.' ';
    			//echo substr($cDate,0,4).' '.$i.'
    			//';
    			if($year != $currentYear){
    				$currentYear = $year;
    				$y++;
    				$yearsArray[$y-1] = $currentYear;
    				$j = 0;
    				echo "\n".'mygroup['.($y-1).'] = new Array();'."\n";
    				echo 'mygroup['.($y-1).']['.$j++.'] = new Option("Wähle einen Eintrag...", 0);'."\n";
    				
    			}
    			echo 'mygroup['.($y-1).']['.$j++.'] = new Option(\''.S2S_Datum_MySql2Deu($Eintrag->getDatum()).' - '.
    				$Eintrag->getTitel(GET_CLIP).'\', '.$Eintrag->getGalerieeintragID().');'."\n";
    		}
    	}
    	
?>
        // mygroup[ZB_PRIMARY_KEY_SELECT][FORTLAUFENDE_ZAHLEN_AB_0] = new Option(OPTION_TEXT, ZB_PRIMARY_KEY_SUBSELECT)

        // alle <option>s des sub-<select> entfernen
        function ResetSubSelect(form, subSelect)
        {
            var e = form.elements[subSelect];
            var node = e.lastChild;
            while(node != null){
            	e.removeChild(node);
            	node = e.lastChild;
            }
        }
        
        // tritt bei onchange in Kraft, bzw. bei der Initiierung
        function ShowSubSelect(elem, subSelect)
        {
            // alle <option>s des sub-<select> entfernen (reset)
            //elem.form.elements[subSelect].length = 0;
            ResetSubSelect(elem.form, subSelect);
            
            // welcher value wurde ausgewählt
            var i = elem.options[elem.selectedIndex].value;
            // sub-<select>
            var s = elem.form.elements[subSelect];
            
            // dem <sub>-select die <option>s aus mygroup zuordnen
            for (var k = 0; k < mygroup[i].length; k++) {
                s.options[k] = mygroup[i][k];
            }
            
        }

        /* ]]> */
    </script>

<form action="index.php" method="get">
	<div class="control"><input type="hidden" name="section" value="galerie" /></div>
    <div><select onchange="ShowSubSelect(this,'galerieeintrag_id')">
<?php 	if(count($GalerieArray))
    	{
    		$y = 0;
    		foreach ($yearsArray as $i => $year)
    		{
    			echo '<option '.(($year==substr($Galerieeintrag->getDatum(),0,4))?('selected="selected"'):('')).'value="'.$y++.'">'.$year.'</option>'."\n";
    		}    	
    	}

?>
    </select>
    
    <select name="galerieeintrag_id" onchange='this.form.submit()'>

<?php 	if(count($GalerieArray)){
			foreach($GalerieArray as $i => $Eintrag){
				if(substr($Galerieeintrag->getDatum(),0,4) == substr($Eintrag->getDatum(),0,4))
					echo '<option '.
					(($Galerieeintrag->getGalerieeintragID() == $Eintrag->getGalerieeintragID())?('selected="selected" '):(' ')).
					'value="'.$Eintrag->getGalerieeintragID().'">'.S2S_Datum_MySql2Deu($Eintrag->getDatum()).' - '.
					$Eintrag->getTitel(GET_CLIP).'</option>'."\n";
			}
		}
?>

    </select>
    
    <!--<input type="submit" value="Anzeigen" />-->
    </div>
</form>

<div>
	<script type="text/javascript">
		// custom buttons must be named customN
		var saved_picasaid,
			saved_authkey;
		function myImgToolbarCustInit(elementName) {
			 if (elementName == 'custom1') {
				return '<a class="gallery_image_download" target="new"><i class="fa fa-download fa-2x"></i></a>';
			}
		}
		
		function myImgToolbarCustDisplay($elements, item, data) {
			var requestUrl = 'https://photos.googleapis.com/data/feed/api/user/germinton/albumid/';
			requestUrl += saved_picasaid;
			requestUrl += '/photoid/';
			requestUrl += item.GetID();
			
			$.get({
				url: requestUrl,
				data: {
					alt: 'json',
					authkey: saved_authkey				
				}
			}).done(function(result) {
				var url = result.feed.media$group.media$content[0].url;
				var title = result.feed.title.$t;
				var width = result.feed.gphoto$width.$t;
				url = url.replace(result.feed.title.$t, '');
				url += 'w' + width + '/' + title;
				$elements.find('.gallery_image_download').attr({
					href: url,
					download: title
				});
			});			
		}
		
		/*
		function myImgToolbarCustClick(elementName, $element, item, data) {
			switch (elementName) {
			case 'custom1':
				alert('click on custom element 1');
				break;			
			}
		}
		*/
		
		function LoadNanoGallery(picasaid, authkey) {
			saved_picasaid = picasaid;
			saved_authkey = authkey;
			var nanoGallerySettings = {
				kind: 'picasa',
				userID: 'germinton',
				album: saved_picasaid + '&authkey=' + saved_authkey,
				paginationMaxLinesPerPage: 1,
				//thumbnailAlignment: 'justified',
				thumbnailWidth: '72C',
				thumbnailHeight: '72C',
				thumbnailLabel: {
				  display: false
				},
				
				viewerToolbar: {
					autoMinimize: 0,
					standard: 'minimizeButton,previousButton,pageCounter,nextButton,playPauseButton,fullscreenButton,custom1,label'
				},
				fnImgToolbarCustInit: myImgToolbarCustInit,
				fnImgToolbarCustDisplay: myImgToolbarCustDisplay,
				//fnImgToolbarCustClick: myImgToolbarCustClick,
				
				theme: 'clean'
			};
			$('.nanogallery').nanoGallery(nanoGallerySettings);
		}
	</script>
	<?php echo $Galerieeintrag->getXHTML(); ?>	
</div>