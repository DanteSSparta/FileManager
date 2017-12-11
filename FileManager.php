<?php
/**
 * Created by PhpStorm.
 * User: ptash
 * Date: 10.12.2017
 * Time: 14:55
 */
class FileManager
{
    protected $path;
    protected $route = array();
    protected $begin_path;

    public function __construct($path)
    {
        $this->path = $path;
        $this->begin_path = $path;
    }

    public function setPath($path)
    {
        $this->path=$path;
    }


    public function setRoute($route)
    {
        $this->route = $route;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function getFiles($path)
    {
        return $files = scandir($path);
    }

    public function getSize($file)
    {
        $size = filesize($file);
        if ($size < 1000) {
        return sprintf('%s B', $size);
    } elseif (($size / 1024) < 1000) {
        return sprintf('%s Kb', round(($size / 1024), 2));
    } elseif (($size / 1024 / 1024) < 1000) {
        return sprintf('%s Mb', round(($size / 1024 / 1024), 2));
    } elseif (($size / 1024 / 1024 / 1024) < 1000) {
        return sprintf('%s Gb', round(($size / 1024 / 1024 / 1024), 2));
    } else {
        return sprintf('%s Tb', round(($size / 1024 / 1024 / 1024 / 1024), 2));
    }
    }

    public function getDateModified($file)
    {
        $default_timezone = 'Europe/Kiev'; 
        date_default_timezone_set($default_timezone);
        return $time = date("d F Y H:i:s", filemtime($file));
    }

    public function separateFilesOrFolders($files)
    {
        $folders = [];
        $fls = [];
        foreach ($files as $file) {
            if ($file == "." || $file == "..") {
                continue;
            }
            if (is_dir($this->path . '/' . $file)) {
                $folders[] = $file;
            } else {
                $fls[] = $file;
            }
        }
        natcasesort($folders);
        natcasesort($fls);
        return $files = [$folders, $fls];
    }

    public function showFoldersAndFile($files)
    {
        $files = $this->separateFilesOrFolders($files);
        if($this->path !=$_SESSION['begin_path']){
        	
        	echo "<tr><td><a href='?back=back'><i class='fa fa-undo'></i></a></td><td>...</td><td>...</td></tr>";
        }

        foreach ($files[0] as $file) {
        	if (!preg_match("$[0-9]$",$file))
        	{
        		echo "<td><div class='filename'><a href='?p=$file'><img src='img/folder-icon.png'></img> $file</a></div></td>";
    		}
    		else
    		{
				echo "<td><div class='filename'><img src='img/folder-icon.png'></img> $file</div></td>";
        		
    		}
    		echo "<td> Папка </td>";
            echo "<td>" . $this->getDateModified($this->path . '/' . $file) . "</td>";
            echo "</tr>";

            
        }
        foreach ($files[1] as $file) {
        	$img = $this->fm_get_file_icon_class($this->path . '/' . $file);
            echo "<tr>";
            echo "<td><div class='filename'><i class='fa fa-$img'></i> $file</div></td>";
            echo "<td>" . $this->getSize($this->path . '/' . $file) . "</td>";
            echo "<td>" . $this->getDateModified($this->path . '/' . $file) . "</td>";
            echo"</tr>";
        }
    }

    public function showFullPath()
    {
        if(!empty($this->route))
        {
            $p="";
            foreach ($this->route as $pat){
                $p .=$pat.'/';
                echo '/' . $pat;
            }

        }
    }

    public function Back($step)
    {
        $i=strripos($this->path,'/');
        $this->path = substr($this->path, 0,$i);
        $_SESSION['current_path'] = $this->path;
        $this->route= $_SESSION['route'];
        array_pop($this->route);
        $_SESSION['route'] = $this->route;
    }

    

	function fm_get_file_icon_class($path)
	{
	// get extension
	$ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

	switch ($ext) {
		case 'ico': case 'gif': case 'jpg': case 'jpeg': case 'jpc': case 'jp2':
		case 'jpx': case 'xbm': case 'wbmp': case 'png': case 'bmp': case 'tif':
		case 'tiff':
		    $img = 'file-image-o';
		    break;
		case 'txt': case 'css': case 'ini': case 'conf': case 'log': case 'htaccess':
		case 'php': case 'php4': case 'php5': case 'phps': case 'phtml':
		case 'passwd': case 'ftpquota': case 'sql': case 'js': case 'json': case 'sh':case 'htm': case 'html': case 'shtml': case 'xhtml':
		case 'config': case 'twig': case 'tpl': case 'md': case 'gitignore':
		case 'less': case 'sass': case 'scss': case 'c': case 'cpp': case 'cs': case 'py':
		case 'map': case 'lock': case 'dtd':
		    $img = 'file-code-o';
		    break;
		case 'zip': case 'rar': case 'gz': case 'tar': case '7z':
		    $img = 'file-zip-o';
		    break;
		case 'wav': case 'mp3': case 'mp2': case 'm4a': case 'aac': case 'ogg':
		case 'oga': case 'wma': case 'mka': case 'flac': case 'ac3': case 'tds':
		    $img = 'file-audio-o';
		    break;
		case 'avi': case 'mpg': case 'mpeg': case 'mp4': case 'm4v': case 'flv':
		case 'f4v': case 'ogm': case 'ogv': case 'mov': case 'mkv': case '3gp':
		case 'asf': case 'wmv':
		    $img = 'file-movie-o';
		    break;
		case 'xls': case 'xlsx':
		    $img = 'file-excel-o';
		    break;
		case 'doc': case 'docx':
		    $img = 'file-word-o';
		    break;
		case 'ppt': case 'pptx':
		    $img = 'file-powerpoint-o';
		    break;
		case 'pdf':
		    $img = 'file-pdf-o';
		    break;
		default:
		    $img = 'file-o';
		}

	return $img;
	}

}