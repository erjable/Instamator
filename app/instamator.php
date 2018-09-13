<?php
// Instamator App v1
// Coded by @erjanulujan
require_once("configurations.php");

class instamatorApp {
    
    public function __construct($iUsername, $iPassword){
        $this->iUsername = $iUsername;
        $this->iPassword = $iPassword;
		$this->perJobCount = 1;
		$this->totalJobCount = 0;
        $this->instagram = new \InstagramAPI\Instagram(false, false);
        $this->rank_token = \InstagramAPI\Signatures::generateUUID();
        $this->max_id = null; 
		try {
			$this->_InsLogin = $this->instagram->login($this->iUsername, $this->iPassword);
			echo "[!] Login successfully!\n\n";
			return true;
		} catch(Exception $e){
			echo "[!] Login unsuccessfully!\n\n";
			exit;
		}
    }
	
	public function userFeedLiker($perCount, $perSecond, $totalCount, $targetUsername){
		do {
			try {
				$targetUser = json_decode($this->instagram->people->getInfoByName($targetUsername), true);
				$targetFeed = $this->instagram->timeline->getUserFeed($targetUser['user']['pk'], $this->max_id);
				echo "\n\n[!] Collecting user media...\n\n";
				sleep(3);
				foreach($targetFeed->getItems() as $userFeed){
					if(!$userFeed->getHasLiked() == "1"){
						$doLike = json_decode($this->instagram->media->like($userFeed->getId()), true);
						if($doLike['status'] == "ok"){
							echo "[{$this->perJobCount}] Liked now => [".$userFeed->getId()."]\n";
							$this->perJobCount++;
							$this->totalJobCount++;
						}else{
							echo "Liked err => [".$userFeed->getId()."]\n";
						}
					}
				if($this->perJobCount > $perCount){
					echo "\n[!] Per successfully completed! Wait ".$perSecond." seconds... [Total:{$this->totalJobCount}/{$totalCount}]\n";
					$this->perJobCount = 1;
					sleep($perSecond);
				}
				if($this->totalJobCount == $totalCount){
					echo "\n\n[!] All pers successfully completed! [Total:{$this->totalJobCount}/{$totalCount}]\n\n";
					exit;
				}
				}
				$this->max_id = $targetFeed->getNextMaxId();
			} catch(Exception $e){
				echo "There was a problem, please try again later.\n";
			}
		} while($this->max_id !== null);
	}
	
    public function timelineFeedLiker($perCount, $perSecond, $totalCount){
        do {
			try {
				$timelineFeeds = $this->instagram->timeline->getTimelineFeed($this->max_id);
				echo "\n\n[!] Collecting users media...\n\n";
				sleep(3);
				foreach($timelineFeeds->getFeedItems() as $timelineFeed){
					$doData = json_decode($timelineFeed->getMediaOrAd(), true);
					if(!$doData['has_liked'] == "1"){
						$doLike = json_decode($this->instagram->media->like($doData['id']), true);
						if($doLike['status'] == "ok"){
							echo "[{$this->perJobCount}] Liked now => [".$doData['id']."]\n";
							$this->perJobCount++;
							$this->totalJobCount++;
						}else{
							echo "Liked err => [".$doData['id']."]\n";
						}
					}
				if($this->perJobCount > $perCount){
					echo "\n[!] Per successfully completed! Wait ".$perSecond." seconds... [Total:{$this->totalJobCount}/{$totalCount}]\n";
					$this->perJobCount = 1;
					sleep($perSecond);
				}
				if($this->totalJobCount == $totalCount){
					echo "\n\n[!] All pers successfully completed! [Total:{$this->totalJobCount}/{$totalCount}]\n\n";
					exit;
				}
				}
				$this->max_id = $timelineFeeds->getNextMaxId();
			} catch(Exception $e){
				echo "There was a problem, please try again later.\n";
			}
		} while($this->max_id !== null);
	}
	
	public function userFollowsFollower($perCount, $perSecond, $totalCount, $targetUsername){
		do {
			try {
				$targetUser = json_decode($this->instagram->people->getInfoByName($targetUsername), true);
				$targetData = json_decode($this->instagram->people->getFollowing($targetUser['user']['pk'], $this->rank_token), true);
				$targetInfo = json_decode($this->instagram->people->getFriendship($targetUser['user']['pk']), true);
				if(!$targetInfo['following'] == 1){
					echo "[!] You are not following the target account, please follow and try again.\n";
					exit;
				}
				echo "\n\n[!] Collecting user follows...\n\n";
				sleep(3);
				foreach($targetData['users'] as $userData){
					$userInfo = json_decode($this->instagram->people->getFriendship($userData['pk']), true); 
					if(!$userInfo['following'] == 1 && !$userInfo['outgoing_request'] == 1){
						$doFollow = json_decode($this->instagram->people->follow($userData['pk']), true);
						if($doFollow['status'] == "ok"){
							echo "[{$this->perJobCount}] Follow now => [".$userData['username']."]\n";
							$this->perJobCount++;
							$this->totalJobCount++;
						}else{
							echo "Follow err => [".$userData['username']."]\n";
						}
					}
				if($this->perJobCount > $perCount){
					echo "\n[!] Per successfully completed! Wait ".$perSecond." seconds... [Total:{$this->totalJobCount}/{$totalCount}]\n";
					$this->perJobCount = 1;
					sleep($perSecond);
				}
				if($this->totalJobCount == $totalCount){
					echo "\n\n[!] All pers successfully completed! [Total:{$this->totalJobCount}/{$totalCount}]\n\n";
					exit;
				}
				}
			} catch(Exception $e){
				echo "There was a problem, please try again later.\n";
			}
		} while($this->max_id !== null);
	}
	
	public function nonFollowChecker($perCount, $perSecond, $totalCount){
		do {
			try {
				$followedData = json_decode($this->instagram->people->getSelfFollowing($this->rank_token), true);
				echo "\n\n[!] The people you follow are collecting...\n\n";
				sleep(3);
				$pollowedData = array();
				foreach($followedData['users'] as $followedUser){
					$userCheck = json_decode($this->instagram->people->getFriendship($followedUser['pk']), true);
					if(!$userCheck['followed_by'] == 1){
						$userData = array('username' => $followedUser['username'], 'user_id' => $followedUser['pk']);
						$userPush = array_push($pollowedData, $userData);
					}
				}
				echo "[!] The people you follow are collected!\n\n";
				sleep(3);
			} catch(Exception $e){
				echo "[!] There was a problem, please try again later.\n\n";
			}
			try {
				echo "[!] There were [".count($pollowedData)."] users who did not follow back.\n\n";
				sleep(3);
				foreach($pollowedData as $pollowedUser){
					$doUnfollow = json_decode($this->instagram->people->unfollow($pollowedUser['user_id']), true);
					if($doUnfollow['status'] == "ok"){
						echo "[{$this->perJobCount}] Unfollowed now => [".$pollowedUser['username']."]\n";
						$this->perJobCount++;
						$this->totalJobCount++;
					}else{
						echo "Unfollowed err => [".$pollowedUser['username']."]\n";
					}
				if($this->perJobCount > $perCount){
					echo "\n[!] Per successfully completed! Wait ".$perSecond." seconds... [Total:{$this->totalJobCount}/{$totalCount}]\n";
					$this->perJobCount = 1;
					sleep($perSecond);
				}
				if($this->totalJobCount == $totalCount){
					echo "\n\n[!] All pers successfully completed! [Total:{$this->totalJobCount}/{$totalCount}]\n\n";
					exit;
				}
				}
			} catch(Exception $e){
				echo "There was a problem, please try again later.\n";
			}	
		} while($this->max_id !== null);
	}		

	public function unfollowAll($perCount, $perSecond, $totalCount){
		do {
			try {
				$followedData = json_decode($this->instagram->people->getSelfFollowing($this->rank_token), true);
				echo "\n\n[!] The people you follow are collecting...\n\n";
				sleep(3);
				foreach($followedData['users'] as $followedUser){
					$doUnfollow = json_decode($this->instagram->people->unfollow($followedUser['pk']), true);
					if($doUnfollow['status'] == "ok"){
						echo "[{$this->perJobCount}] Unfollowed now => [".$followedUser['username']."]\n";
						$this->perJobCount++;
						$this->totalJobCount++;
					}else{
						echo "Unfollowed err => [".$followedUser['username']."]\n";
					}
				if($this->perJobCount > $perCount){
					echo "\n[!] Per successfully completed! Wait ".$perSecond." seconds... [Total:{$this->totalJobCount}/{$totalCount}]\n";
					$this->perJobCount = 1;
					sleep($perSecond);
				}
				if($this->totalJobCount == $totalCount){
					echo "\n\n[!] All pers successfully completed! [Total:{$this->totalJobCount}/{$totalCount}]\n\n";
					exit;
				}
				}
			} catch(Exception $e){
				echo "There was a problem, please try again later.\n";
			}	
		} while($this->max_id !== null);
	}	
	
}
