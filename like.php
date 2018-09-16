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

if (isset($_GET['artId'])) $artId = $_GET['artId'];
if (isset($_GET['comId'])) $comId = $_GET['comId'];

if (isset($_GET['rate'])) $rateNb = $_GET['rate'];
if (isset($_GET['like'])) $likeNb = $_GET['like'];

$errorNb = false;

if ((!isset($artId) AND !isset($comId)) AND (!isset($rateNb) AND !isset($likeNb))) $errorNb = true;
else
    {
	 if (isset($artId))
		{
        # validation du numéro de commentaire
        if(!preg_match('/^?[0-9]{4}$/',$_GET['artId'])) {
            plxMsg::Error(L_ERR_INVALID_ARTICLE_IDENT);
            $errorNb = 2;
            header('Location: article.php');
            exit;
        }
		
//		plxAdmin::rateArticle($artId,$likeNb,$rateNb);
		echo $artId." ".$rate;
		}
	 else
	 if (isset($comId))
		{
        # validation du numéro de commentaire
        	if(!preg_match('/^?[0-9]{4}$/',$_GET['artId'])) {
                plxMsg::Error(L_ERR_INVALID_ARTICLE_IDENT);
            $errorNb = 3;
            header('Location: comments.php');
            exit;
        }
		//if (!plxAdmin::rateCommentaire($comId,$likeNb)) $errorNb = -1;
		echo $comId." ".$rate;
		}
	}
if ($errorNb) { header('HTTP/1.1 400 Bad Request'); exit; }
ob_end_flush()
?>
