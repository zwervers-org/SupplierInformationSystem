<?php
$dir = array();
foreach (new DirectoryIterator($address) as $file)	{
    if($file->isDot())	{ continue;}

    if($file->isDir())	{
		$file1 = $file->getFilename();
		
		$dir2 = array();
		$path = $address.'/'.$file1;
		foreach (new DirectoryIterator($path) as $file2)	{
			if($file2->isDot())	{ continue;}

			if($file2->isDir())	{
				array_push($dir2, $file2->getFilename());
				}
		}
	if ($dir2 <> array())	{
		$dir[$file1] = $dir2;}
	else	{
		$dir[$file1] = $file1;}
	}
}
echo '<div id="sitemap"><ul>';
echo '<label>ROOT</label>';
$i = 1;
$l = 1;
foreach ($dir as $a => $b)	{
	echo '<div id="map'.$i.'"><ul>';
	echo '<label>'.ucfirst($a).'</label>';
	
	if(is_array($b))	{
	$i = $i + 1;
		foreach ($b as $c => $d)	{
		echo '<div id="map'.$i.'">';
		echo '<ul>';
		echo '<label id="content1">'.ucfirst($d).'</label>';
		$diradd = $address.'/'.$a.'/'.$d;
			foreach(new DirectoryIterator($diradd) as $v) {
				if($v->isDot())	{ continue;}

				if($v->isFile())	{
					$pos = strrpos($v, '.');
					$name = substr($v, 0, $pos - 0);
					$ext = substr($v, $pos + 1);
					#echo 'ext = '.$ext;
					
					switch ($ext)	{
						case 'php':
						case 'css':
							echo '<li id="content'.$i.'"><a href="index.php?page='.$name.'">'.ucfirst($name).'</a></li>';
							break;
						case 'jpg':
						case 'gif':
						case 'jpeg':
						case 'png':
							echo '<li id="content'.$i.'">';
							echo '<a href="'.$a.'/'.$name.'.'.$ext.'">'.ucfirst($name.'.'.$ext).'
								<img src="'.$a.'/'.$name.'.'.$ext.'"></a></li>';
							break;
						default:
							break;
					}
				}
			}
		echo "</ul></div>";
		}
	}
	$diradd = $address.'/'.$a;
	$i = 1;
	foreach(new DirectoryIterator($diradd) as $v) {
		if($v->isDot())	{ continue;}

		if($v->isFile())	{
			$pos = strrpos($v, '.');
			$name = substr($v, 0, $pos - 0);
			$ext = substr($v, $pos + 1, +3);
			
			switch ($ext)	{
				case 'php':
				case 'css':
					echo '<li id="content1"><a href="index.php?page='.$name.'">'.ucfirst($name).'</a></li>';
					break;
				case 'jpg':
				case 'gif':
				case 'jpeg':
				case 'png':
					echo '<li id="content1"><a href="'.$a.'/'.$name.'.'.$ext.'">'.ucfirst($name.'.'.$ext).'
						<img src="'.$a.'/'.$name.'.'.$ext.'"></a></li>';
					break;
				default:
					break;
			}
		}
	}
echo '</ul></div>';
}
echo '</ul></div>';
?>