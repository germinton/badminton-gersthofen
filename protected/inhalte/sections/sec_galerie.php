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
	<?php echo $Galerieeintrag->getXHTML(); ?>
</div>