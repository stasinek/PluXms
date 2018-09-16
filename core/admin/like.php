<?php
ob_start();

define('PLX_ROOT', './');
define('PLX_CORE', PLX_ROOT.'core/');
include(PLX_ROOT.'config.php');
include(PLX_CORE.'lib/config.php');

# On démarre la session
session_start();

# On inclut les librairies nécessaires
include(PLX_CORE.'lib/class.plx.date.php');
include(PLX_CORE.'lib/class.plx.glob.php');
include(PLX_CORE.'lib/class.plx.utils.php');
include(PLX_CORE.'lib/class.plx.capcha.php');
include(PLX_CORE.'lib/class.plx.erreur.php');
include(PLX_CORE.'lib/class.plx.record.php');
include(PLX_CORE.'lib/class.plx.motor.php');
include(PLX_CORE.'lib/class.plx.feed.php');
include(PLX_CORE.'lib/class.plx.show.php');
include(PLX_CORE.'lib/class.plx.encrypt.php');
include(PLX_CORE.'lib/class.plx.plugins.php');
include(PLX_CORE.'lib/class.plx.msg.php');

# Creation de l'objet principal et lancement du traitement
$plxMotor = plxMotor::getInstance();

# Détermination de la langue à utiliser (modifiable par le hook : Index)
$lang = $plxMotor->aConf['default_lang'];

# Hook Plugins
// eval($plxMotor->plxPlugins->callHook('Index'));

# chargement du fichier de langue
loadLang(PLX_CORE.'lang/'.$lang.'/core.php');

ob_clean();

if (isset($_GET['a'])) $art = $_GET['a'];
if (isset($_GET['c'])) $com = $_GET['c'];

if (isset($_GET['rate'])) $rate = $_GET['rate'];
if (isset($_GET['like'])) $like = $_GET['like'];

$error = false;

if ((!isset($art) AND !isset($com)) AND (!isset($rate) AND !isset($like))) $error = true;
else
    {
	 if (isset($art))
		{
        # validation du numéro de commentaire
        if(!preg_match('/^?[0-9]{4}$/',$art) ? true :
            ($aFile = $plxAdmin->plxGlob_arts->query('/^'.$art.'.(.+).xml$/','','sort',0,1)) == false) {
                plxMsg::Error(L_ERR_INVALID_COMMENT_IDENT);
                $error = 2;
                header('Location: index.php');
                exit;
        }
//		plxAdmin::rateArticle($artId,$likeNb,$rateNb);
		echo $art." ".$rate;
		}
	 else
	 if (isset($comId))
		{
        # validation du numéro de commentaire
        if(!preg_match('/^?[0-9]{4}$/',$com) ? true :
            ($aFile = $plxAdmin->plxGlob_comm->query('/^'.$com.'.(.+).xml$/','','sort',0,1)) == false) {
                plxMsg::Error(L_ERR_INVALID_ARTICLE_IDENT);
                $error = 3;
                header('Location: comments.php');
                exit;
        }
		//if (!plxAdmin::rateCommentaire($comId,$likeNb)) $errorNb = -1;
		echo $com." ".$rate;
		}
	}
if ($error) { header('HTTP/1.1 400 Bad Request'); exit; }
ob_end_flush()
?>
