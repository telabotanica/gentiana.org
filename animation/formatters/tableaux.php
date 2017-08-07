<?php
	function parsetable($thing)
	{
		$tableattr = 'border="1"';
//		echo "parsetable debut : \$thing = $thing<br>";
		// recuperation des attributs
		preg_match("/^\[\|(.*)$/m",$thing,$match);
//		echo "parsetable : \$match = ";var_dump($match);echo "<br>";		
		if ($match[1]){
			$tableattr = $match[1];
		}
		$table = "<table $tableattr >\n";
		//suppression de [|xxxx et de |]
		$thing = preg_replace("/^\[\|(.*)$/m","",$thing);
		$thing = trim(preg_replace("/\|\]/m","",$thing));
//		echo "parsetable suppression [| |]: \$thing = $thing<br>";
		//recuperation de chaque ligne
		$rows = preg_split("/$/m",$thing,-1,PREG_SPLIT_NO_EMPTY);
//		echo "parsetable preg_split:";var_dump($rows);echo "<br>";
		//analyse de chaque ligne
		foreach ($rows as $row){
			$table .= parsetablerow($row);
		}
		$table.= "</table>";
		return $table;
	}
	//parse la definition d'une ligne
	function parsetablerow($row)
	{
		$rowattr = "";
		
		$row = trim($row);
//		echo "parsetablerow debut : \$row = $row<br>";
		//detection des attributs de ligne => si la ligne ne commence pas par | alors attribut
		if (!preg_match("/^\|/",$row,$match)){
			preg_match("/^!([^\|]*)!\|/",$row,$match);
			$rowattr = $match[1];
//			echo "\$rowattr = $rowattr<br>";
			$row = trim(preg_replace("/^!([^\|]*)!/","",$row));
		}
		$result .= "   <tr $rowattr>\n";
		$row = trim(preg_replace("/^\|/","",trim($row)));
		$row = trim(preg_replace("/\|$/","",trim($row)));
//		echo "parsetablerow sans attribut : \$row = $row<br>";
		
		//recuperation de chaque cellule
		$cells = explode("|",$row);	//nb : seule les indices impaire sont significatif
//		echo "parsetablerow preg_split \$cells:";var_dump($cells);echo "<br>";
		$i=0;
		foreach ($cells as $cell){
//			if ($i % 2){
//				echo "\$cell = $cell<br>";
				$result .= parsetablecell($cell);
//			}
			$i++;
		}
		$result .= "   </tr>\n";
		return $result;
	}
	//parse la definition d'une cellule
	function parsetablecell($cell)
	{
		global $wiki;
		$cellattr = "";
		
		if (preg_match("/^!(.*)!/",$cell,$match)){
			$cellattr = $match[1];
		}
		$cell = preg_replace("/^!(.*)!/","",$cell);
		//si espace au debut => align=right
		//si espace a la fin => align=left
		//si espace debut et fin => align=center
		if (preg_match("/^\s(.*)/",$cell)){
			$align="right";
		}
		if (preg_match("/^(.*)\s$/",$cell)){
			$align="left";
		}
		if (preg_match("/^\s(.*)\s$/",$cell)){
			$align="center";
		}
		if ($align) $cellattr .= " align=\"$align\"";
//		echo "\$this->classname = ".get_class($wiki)."<br>";
		return "      <td $cellattr>".$wiki->Format($cell)."</td>\n";
	}

?>
