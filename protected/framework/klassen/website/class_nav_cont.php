<?php
/*******************************************************************************************************************//**
 * Container-Klasse für Objekte der Klasse CNav. Ein Objekt repräsentiert praktisch eine komplette Navigationsleiste als
 * 'ul'-XHTML-Element mit den einzelen Navigationspunkten als 'li'-XHTML-Elemente.
 **********************************************************************************************************************/
class CNavCont
{

	private $mAttrib = ''; ///< Das 'id'-Attribut für das 'ul'-XHTML-Element
	private $mNavArray = array(); ///< Array für Objekte der Klasse CNav

	/*****************************************************************************************************************//**
	 * @name Magics
	 **************************************************************************************************************//*@{*/

	public function __construct($Attrib) {$this->mAttrib = $Attrib;}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name Verschiedenes
	 **************************************************************************************************************//*@{*/

	public function getCount() {return count($this->mNavArray);}

	public function getNavForSecString($SecString)
	{
		foreach($this->mNavArray as $Nav) {
			if($Nav->getSecString() == $SecString) {return $Nav;}
		}
	}

	public function getSubNavArrayForSecString($SecString)
	{
		$NavArray = $this->mNavArray;
		if(!($Nav = reset($NavArray))) {throw new Exception('Keine Navigationspunkte im Container!');}
		if($Nav->getSecString() != $SecString)
		{
			while($Nav = next($NavArray)) {
				if($Nav->getSecString() == $SecString) {break;}
			}
		}
		$SubNavArray = array();
		if(!$Nav) {return $SubNavArray;}
		$ActStage = $Nav->getStage();
		while($Nav = next($NavArray))
		{
			if($Nav->getStage() == ($ActStage+1)) {$SubNavArray[] = $Nav;}
			else if($Nav->getStage() <= $ActStage) {break;}
		}
		return $SubNavArray;
	}

	public function getNavArrayForSecondaryNav($SecString)
	{
		$NavResultArray = array();
		$ActStage = 0;
		$Nav = end($this->mNavArray);
		if($Nav->getSecString() == $SecString)
		{
			$ActStage = $Nav->getStage();
			$NavResultArray[$ActStage] = $Nav;
		}
		while(!$ActStage and ($Nav = prev($this->mNavArray)))
		{
			if($Nav->getSecString() == $SecString)
			{
				$ActStage = $Nav->getStage();
				$NavResultArray[$ActStage] = $Nav;
			}
		}
		while(($ActStage != 1) and ($Nav = prev($this->mNavArray)))
		{
			$NewStage = $Nav->getStage();
			if($NewStage == ($ActStage - 1))
			{
				$NavResultArray[$NewStage] = $Nav;
				$ActStage = $NewStage;
			}
		}
		return $NavResultArray;
	}

	public function spc($nbr) {$space = ''; for($i=0; $i<$nbr; $i++) {$space .= ' ';} return $space;}
	public function add($Nav) {$this->mNavArray[] = $Nav;}

	private function updateNavAthletIDArray(&$NavArray)
	{
		/////////////////////////////////
		// 'stufenaufwärts' ergänzen
		/////////////////////////////////
		$Nav = reset($NavArray);

		$AthletIDArrayArray = array();

		$ActStage = $Nav->getStage();
		$AthletIDArrayArray[$ActStage] = $Nav->getAthletIDArray();

		while($Nav = next($NavArray))
		{
			$ActStage = $Nav->getStage();
			$AthletIDArrayArray[$ActStage] = $Nav->getAthletIDArray();

			$ResultAthletIDArray = array();
			for($i=1; $i<=$ActStage; $i++) {
				$ResultAthletIDArray = array_unique(array_merge($AthletIDArrayArray[$i], $ResultAthletIDArray));
			}
			$Nav->setAthletIDArray($ResultAthletIDArray);
		}

		/////////////////////////////////
		// 'stufenabwärts' ergänzen
		/////////////////////////////////

		$Nav = reset($NavArray);

		$ActStage = $Nav->getStage();
		if(1 != $ActStage) {throw new Exception('Erster Navigationspunkt muss von Stufe 1 sein!');}

		$CriticalNavArray = array();
		$CriticalAthletIDArray = array();

		$CriticalNavArray[$ActStage] = $Nav;
		$CriticalAthletIDArray[$ActStage] = $Nav->getAthletIDArray();

		while($Nav = next($NavArray))
		{
			$ActStage = $Nav->getStage();

			$CriticalNavArray[$ActStage] = $Nav;
			$CriticalAthletIDArray[$ActStage] = $Nav->getAthletIDArray();

			for($i=$ActStage-1; $i>=1; $i--)
			{
				if(count($CriticalAthletIDArray[$i]))
				{
					$ResultAthletIDArray = array_unique(array_merge($CriticalAthletIDArray[$i+1], $CriticalAthletIDArray[$i]));
					$CriticalNavArray[$i]->setAthletIDArray($ResultAthletIDArray);
					$CriticalAthletIDArray[$i] = $ResultAthletIDArray;
				}
			}
		}

	}

	private function updateNavStageFlags(&$NavArray)
	{
		$ActStage = reset($NavArray)->getStage();
		if(1 != $ActStage) {throw new Exception('Erster Navigationspunkt muss von Stufe 1 sein!');}
		while($Nav = next($NavArray))
		{
			$Nav->resetStageFlags();
			$NewStage = $Nav->getStage();
			if($NewStage <= 0) {
				throw new Exception('Navigationspunkte dürfen nicht von Stufen kleiner gleich 0 sein!');
			}
			$StageDiff = $Nav->getStage()-$ActStage;
			if($StageDiff > 0 and 1 != $StageDiff) {
				throw new Exception('Navigationsunterpunkte dürfen keine Stufe überspringen!');
			}
			if(1 == $StageDiff) {$Nav->setStageUp();}
			else if($StageDiff < 0) {$Nav->setStagesDown($ActStage-$NewStage);}
			$ActStage = $NewStage;
		}
	}

	public function filter($Mitglied)
	{
		if(!reset($this->mNavArray)) {throw new Exception('Keine Navigationspunkte im Container!');}
		$this->updateNavAthletIDArray($this->mNavArray);



		if($Mitglied instanceof CMitglied)
		{
			if(!$Mitglied->hatAufgabe(S_DBENTWICKLER))
			{
				$MitgliedAthletID = $Mitglied->getAthletID();
				foreach($this->mNavArray as $i => $Nav)
				{
					if(!count($AthletIDArray = $Nav->getAthletIDArray())) {continue;}
					if(!in_array($MitgliedAthletID, $AthletIDArray)) {unset($this->mNavArray[$i]);}
				}
			}
		}
		else
		{
			$this->mNavArray = array();
		}
	}

	/*@}*/

	/*****************************************************************************************************************//**
	 * @name XHTML-Getter
	 **************************************************************************************************************//*@{*/

	public function getXHTMLForPrimaryNav($UntilStage)
	{
		$NavArray = $this->mNavArray;
		if(!reset($NavArray)) {throw new Exception('Keine Navigationspunkte im Container!');}
		foreach($NavArray as $i => $Nav) {
			if($Nav->getStage() > $UntilStage) {unset($NavArray[$i]);}
		}
		$this->updateNavStageFlags($NavArray);
		reset($NavArray);
		$xhtml = '<ul id="'.$this->mAttrib.'" class="'.$this->mAttrib.'_stage1">'."\n";
		self::getXHTMLForPrimaryNavRecursively($NavArray, $xhtml);
		return $xhtml .= '</ul>'."\n";
	}

	public function getXHTMLForSecondaryNav($SecString)
	{
		if($NavArray = self::getNavArrayForSecondaryNav($SecString))
		{
			$xhtml = '';
			for($i=1; $i<=count($NavArray); $i++)
			{
				$xhtml .= $NavArray[$i]->getXHTMLForLink();
				if($i < count($NavArray)) {$xhtml .= ' > ';}
			}
			return $xhtml;
		}
	}

	private function getXHTMLForPrimaryNavRecursively(&$NavArray, &$xhtml)
	{
		while($Nav = current($NavArray))
		{
			$ActStage = $Nav->getStage();
			$xhtml .= $this->spc(2+($ActStage-1)*4).'<li>'.$Nav->getXHTMLForLink();
			$NbrToClose = 0;
			if($NavNext = next($NavArray))
			{
				$NewStage = $NavNext->getStage();
				if($NavNext->getStageUp())
				{
					$xhtml .= "\n".$this->spc(4+($ActStage-1)*4).'<ul class="'.$this->mAttrib.'_stage'.$NewStage.'">'."\n";
					self::getXHTMLForPrimaryNavRecursively($NavArray, $xhtml);
				}
				else $xhtml .= '</li>'."\n";
				$NbrToClose = $NavNext->getStagesDown();
			}
			else
			{
				$xhtml .= '</li>'."\n";
				$NbrToClose = $ActStage - 1;
			}
			for($i=0; $i<$NbrToClose; $i++)
			{
				$xhtml .= $this->spc(($ActStage*4)-(4*($i+1))).'</ul>'."\n";
				$xhtml .= $this->spc(($ActStage*4)-(4*($i+1))-2).'</li>'."\n";
			}
		}
	}

	/*@}*/
}
?>