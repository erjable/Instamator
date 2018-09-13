<?php
// Instamator App v1
// Coded by @erjanulujan
require_once("./vendor/autoload.php");
require("instamator.php");
echo "=============INFOS===========\n\n";
echo "[!] Github: erjanulujan\n";
echo "[!] Coded by: Ercan Ulucan\n";
echo "[!] Instagram: @erjanulujan\n\n";
echo "=============TOOLS===========\n\n";
echo "1) User Feed Liker\n";
echo "2) Timeline Feed Liker\n";
echo "3) Mass Follower\n";
echo "4) Mass Unfollower\n";
echo "5) Mass All Unfollower\n";
echo "\n=============================\n";
echo "[?] Choose A Job:";
$chooseJob = trim(fgets(STDIN, 1024));
if($chooseJob == 1){
	echo "[!] User Feed Liker Starting. . .\n\n";
	sleep(2);
	echo "[?] Your Username:";
	$iUsername = trim(fgets(STDIN, 1024));
	echo "[?] Your Password:";
	$iPassword = trim(fgets(STDIN, 1024));
	echo "\n[!] Try To Login Your Account. . .\n";
	$i = new instamatorApp($iUsername, $iPassword);
	sleep(2);
	echo "[?] Per Count:";
	$perCount = trim(fgets(STDIN, 1024));
	echo "[?] Per Second:";
	$perSecond = trim(fgets(STDIN, 1024));
	echo "[?] Total Count:";
	$totalCount = trim(fgets(STDIN, 1024));
	echo "[?] Target Username:";
	$targetUsername = trim(fgets(STDIN, 1024));
	$i->userFeedLiker($perCount, $perSecond, $totalCount, $targetUsername);
}else if($chooseJob == 2){
	echo "[!] Timeline Feed Liker Starting. . .\n\n";
	sleep(2);
	echo "[?] Your Username:";
	$iUsername = trim(fgets(STDIN, 1024));
	echo "[?] Your Password:";
	$iPassword = trim(fgets(STDIN, 1024));
	echo "\n[!] Try To Login Your Account. . .\n";
	$i = new instamatorApp($iUsername, $iPassword);
	sleep(2);
	echo "[?] Per Count:";
	$perCount = trim(fgets(STDIN, 1024));
	echo "[?] Per Second:";
	$perSecond = trim(fgets(STDIN, 1024));
	echo "[?] Total Count:";
	$totalCount = trim(fgets(STDIN, 1024));
	$i->timelineFeedLiker($perCount, $perSecond, $totalCount);
}else if($chooseJob == 3){
	echo "[!] Mass Follower Starting. . .\n\n";
	sleep(2);
	echo "[?] Your Username:";
	$iUsername = trim(fgets(STDIN, 1024));
	echo "[?] Your Password:";
	$iPassword = trim(fgets(STDIN, 1024));
	echo "\n[!] Try To Login Your Account. . .\n";
	$i = new instamatorApp($iUsername, $iPassword);
	sleep(2);
	echo "[?] Per Count:";
	$perCount = trim(fgets(STDIN, 1024));
	echo "[?] Per Second:";
	$perSecond = trim(fgets(STDIN, 1024));
	echo "[?] Total Count:";
	$totalCount = trim(fgets(STDIN, 1024));
	echo "[?] Target Username:";
	$targetUsername = trim(fgets(STDIN, 1024));
	$i->userFollowsFollower($perCount, $perSecond, $totalCount, $targetUsername);
}else if($chooseJob == 4){
	echo "[!] Mass Unfollower Starting. . .\n\n";
	sleep(2);
	echo "[?] Your Username:";
	$iUsername = trim(fgets(STDIN, 1024));
	echo "[?] Your Password:";
	$iPassword = trim(fgets(STDIN, 1024));
	echo "\n[!] Try To Login Your Account. . .\n";
	$i = new instamatorApp($iUsername, $iPassword);
	sleep(2);
	echo "[?] Per Count:";
	$perCount = trim(fgets(STDIN, 1024));
	echo "[?] Per Second:";
	$perSecond = trim(fgets(STDIN, 1024));
	echo "[?] Total Count:";
	$totalCount = trim(fgets(STDIN, 1024));
	$i->nonFollowChecker($perCount, $perSecond, $totalCount);
}else if($chooseJob == 5){
	echo "[!] Mass All Unfollower Starting. . .\n\n";
	sleep(2);
	echo "[?] Your Username:";
	$iUsername = trim(fgets(STDIN, 1024));
	echo "[?] Your Password:";
	$iPassword = trim(fgets(STDIN, 1024));
	echo "\n[!] Try To Login Your Account. . .\n";
	$i = new instamatorApp($iUsername, $iPassword);
	sleep(2);
	echo "[?] Per Count:";
	$perCount = trim(fgets(STDIN, 1024));
	echo "[?] Per Second:";
	$perSecond = trim(fgets(STDIN, 1024));
	echo "[?] Total Count:";
	$totalCount = trim(fgets(STDIN, 1024));
	$i->unfollowAll($perCount, $perSecond, $totalCount);
}else{
	exit;
}

