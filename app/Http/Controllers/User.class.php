<?php
/**
 * This class handle users properties 
 * @package      vista
 * @subpackage   user
 * @author 		 AlinB
 * $Id: User.class.php,v 1.1 2008/12/03 16:58:26 alinb Exp $
 */
/**
 * @package vista
 */
class User
{
	
//[start] Local Variables
	protected $oDatabase;
//[end]

//[start] Constructor
	public function __construct(Vista $Vista){
		
		$this->Vista =& $Vista;
		$this->oDatabase = $Vista->Database();
		
	}
//[end]

//----------------------------------------------------------------------------------------
//	
//----------------------------------------------------------------------------------------
//[start] Public Methods
	
	
	/*
	  [id] => 100404714849059451794
    [email] => alina.bugeag@gmail.com
    [verified_email] => 1
    [name] => Alina Bugeag
    [given_name] => Alina
    [family_name] => Bugeag
    [link] => https://plus.google.com/+AlinaBugeag
    [picture] => https://lh3.googleusercontent.com/-PkrpNOCb7Lc/AAAAAAAAAAI/AAAAAAAAvRM/fKgKic1RsmU/photo.jpg
    [gender] => female
	*/
	
	public function getAgencyIdBySubAgent($vUserId){
		$vAgencyUserId=0;
		$aAgency=$this->oDatabase->getRow('agency', array('agency_id'), 'user_id='.$vUserId );
		if(!empty($aAgency))
			$vAgencyUserId=$aAgency['agency_id'];
	
		return $vAgencyUserId;
	}
	public function isUserAdmin($vUserId){
		$bIsParent=0;
		$aAgency = $this->oDatabase->getRow('agency', array('agency_id'), 'agency_id='.$vUserId );
		if(!empty($aAgency['agency_id']))
			$bIsParent=1;
		return $bIsParent;
	}
	public function getSubAgents($vUserId){
		$aAgents = $this->oDatabase->getAll('agency', array('user_id'), 'agency_id='.$vUserId );
		$aSubAgents=array();
		foreach($aAgents as $val){
			$aSubscribtion = $this->oDatabase->getRow('users', array('subscribtion'), 'user_id='.$val['user_id'] );
			if($aSubscribtion['subscribtion']=='4')
				$aSubAgents[] = $val['user_id'];
		}
		return $aSubAgents;
	}
	public function allowedToTranslate($vUserId){
		$aUser=$this->oDatabase->getRow('users',array('user_id'),"user_id=".$vUserId."  and date_format(date_created, '%Y-%m-%d')<date_format(NOW() - interval 1 year , '%Y-%m-%d') and subscribtion='1'");
		
		if(!empty($aUser['user_id']))
			return "show";
		else
			return 'hide';
	}
	public function getAgencySubAgents($vUserId){
		
		$aSubAgents = array();		
		
		$aSubAgents[] = $vUserId;
		
		$aAgency = $this->oDatabase->getRow('agency', array('agency_id'), 'user_id='.$vUserId );
		
		if($aAgency['agency_id']>0)
		{
			$aAgencySubAgents = $this->oDatabase->getAll('agency', array('user_id'), 'agency_id='.$aAgency['agency_id']);
			
			$aSubAgents[] = $aAgency['agency_id'];
			foreach($aAgencySubAgents as $valAgent)
				if($vUserId!=$valAgent)
				{
					$aSubscribtion = $this->oDatabase->getRow('users', array('subscribtion'), 'user_id='.$valAgent['user_id'] );
					if($aSubscribtion['subscribtion']==4)
						$aSubAgents[] = $valAgent['user_id'];
				}
		}
		
		return $aSubAgents;
	}
	
	public function addUser($oGoogleInfo,$sAffiliatesLink='')
	{
		$vAffiliatedParentUser=0;
		if(strlen($sAffiliatesLink)>0){
			$bAffiliated=1;
			$vAffiliatedParentUser=$this->getParentUserIdAffiliates($sAffiliatesLink);
			//echo "parent user affiliated: ".$vAffiliatedParentUser;die;
		}
		else
			$bAffiliated=0;
			//affiliated_parent_user
		// check if we have the account
		$this->oDatabase->insert('users', array('user_name', 'first_name', 'last_name', 'email', 'google_id', 'date_created', 'verified_email', 'google_plus_page', 'picture', 'gender','is_affiliated'), array($oGoogleInfo->email, $oGoogleInfo->given_name, $oGoogleInfo->family_name, $oGoogleInfo->email, $oGoogleInfo->sub, date('Y-m-d H:i:s',time()), ($oGoogleInfo->email_verified?1:0), $oGoogleInfo->link, $oGoogleInfo->picture, $oGoogleInfo->gender,$bAffiliated));
		
		$vUserId = $this->oDatabase->lastid();
		
		// create the rss entry
		$oRss = $this->Vista->Rss();
		$oRss->createRSS($vUserId);
		$oUserExtraData=$this->Vista->User_Extra_Data();
		$oUserExtraData->checkRow($vUserId);
		$this->oDatabase->update('user_extra_data', array('affiliated_parent_user'=>$vAffiliatedParentUser),'user_id='.$vUserId);
		
		// log the activity
		if($bAffiliated>0){
			$aParam=array('created'=>'1','user_id'=>$vAffiliatedParentUser,'token'=>$sAffiliatesLink,'affiliated_user_id'=>$vUserId,'date_created'=>date('Y-m-d H:i:s'));
			$this->addAffiliatesInfo($sAffiliatesLink,$aParam);
		}
		
		$this->oDatabase->insert('user_activity', array('user_id','activity','action_date','moderation_id'), array($vUserId, 'new_account', date('Y-m-d H:i:s',time()), 0));
		
		// create the folder
		$sFolder = '/var/www/html/google/moderation/'.$vUserId;
		
		if(!is_dir($sFolder))
			mkdir($sFolder,0777,true);
		
		return $vUserId;
	}
	
	public function updUser($vUserId, $aUserInfo)
	{
		$this->oDatabase->update('users', $aUserInfo, 'user_id='.$vUserId);
	}
	
	public function getLastToken($vUserId){
		
		$aSession = $this->oDatabase->getRow('auth', array('token_id','is_active','date_created','user_id','token_id'), 'is_active="1" and user_id='.$vUserId.' order by date_created desc');
		
		if(isset($aSession['token_id']))
		{
			return $aSession['token_id'];
		}
	}
	
	/* $aSession = $this->oDatabase->getRow('auth', array('token_id','is_active','date_created','user_id','token_id'), 'is_active="1" and user_id="'.$vUserId.'"');
	
	if(isset($aSession['token_id']))
	{
		return $aSession['token_id'];
	}
	 */
	public function isAgencySubAgent($aAgencyId,$sEmail)
	{
		$aUser=array();
		$vUserId=0;
		$aUser = $this->oDatabase->getRow('users', array('user_id', 'user_name', 'email'), 'user_id="'.$sEmail.'"' );
		if(isset($aUser['user_id'])){
			$aAgency=$this->oDatabase->getRow('agency', array('agency_id'), 'user_id="'.$aUser['user_id'].'"' );
			if(!empty($aAgency) && $aAgency['agency_id']==$aAgencyId)
			$vUserId=$aUser['user_id'];
		}
		return $vUserId;
	}
	
	public function isGoogleTokenExpired($vUserId) {
		$bGoogleToken = 'false';
		$emptyAccounts = 0;
		$totalAccounts = 0;
		$aUser = $this->oDatabase->getAll ( 'auth_publish', array ('user_id', 'token_id', 'email' ), 'user_id=' . $vUserId );
		$totalAccounts = count( $aUser );
		
		foreach ( $aUser as $user ) {
			if (empty ( $user ['token_id'] ))
				$emptyAccounts ++;
		}
		
		if ($emptyAccounts == count($aUser))
			   $bGoogleToken = 'true';
		else
			$bGoogleToken = 'false';
		return $bGoogleToken;
	}
		
	public function isAffiliatedAccount($vUserId) {
		$bResponse = 0;
		$aInfo = $this->oDatabase->getRow( 'users', array ('is_affiliated' ), 'user_id=' . $vUserId );
		
		if (isset ( $aInfo ['is_affiliated'] ) && $aInfo ['is_affiliated'] > 0)
			$bResponse = 1;
		
		return $bResponse;
	}
	
	public function addSubscribtion($vUserId, $vSubscribtion, $rp = '') {
		$bIsAffiliatedAccount=$this->isAffiliatedAccount($vUserId);
		
		
		$this->oDatabase->update ( 'users', array ('subscribtion' => $vSubscribtion ), 'user_id=' . $vUserId );
		if (! empty ( $rp ))
			$this->oDatabase->update ( 'user_extra_data', array ('recurring_profile' => $rp, 'pnref_date' => date ( 'Y-m-d H:i:s', time () ) ), 'user_id=' . $vUserId );
			// print_r($this->oDatabase);
		if ($bIsAffiliatedAccount>0) {
			$expiredDate = date('Y-m-d H:i:s',strtotime(date("Y-m-d H:i:s", time()) . " + 365 day")); 
			if ($vSubscribtion == 1) 
				$aParam = array ('subs_month' => '1','pay_active'=>'1','subs_year' => '0','date_subscribtion'=>date('Y-m-d H:i:s',time()), 'date_expires'=>$expiredDate );
	    	else if ($vSubscribtion == 6) {
					$aParam = array ( 'subs_month' => '0','pay_active'=>'1','subs_year' => '1','date_subscribtion'=>date('Y-m-d H:i:s',time()),'date_expires'=>$expiredDate);
				}
				$this->updateAffiliatesInfo($vUserId, $aParam);
			}
			
			
		
	}
	public function updateAffiliatesInfo($vUserId, $aParam) {
		$this->oDatabase->update ( 'affiliates_program', array ('date_subscribtion'=>$aParam['date_subscribtion'],'subs_month'=> $aParam['subs_month'],'subs_year'=> $aParam['subs_year'] , 'date_expires'=>$aParam['date_expires'],'pay_active'=>'1'),'affiliated_user_id='.$vUserId);
		
	
	}
	
	
	public function addAffiliatesInfo($sAffiliatesLink, $aParam) {
		
		 $this->oDatabase->insert ( 'affiliates_program', array_keys ( $aParam ), array_values ( $aParam ) );
		 
		
	}
	
	public function getPayout($vUserId){
		$vTotalPayout=0;
		$monthlyCommision=23.95*0.08;//1.916
		$yearlyCommision=263.45*0.08;//21.076
		$aUsers=$this->oDatabase->getAll('user_extra_data',array('user_id'),'affiliated_parent_user='.$vUserId);
		//date_format(date_subscribtion, '%Y-%m')=date_format(NOW(), '%Y-%m')
		foreach($aUsers as $val){
			$aAffiliatedUser=$this->oDatabase->getRow('affiliates_program',array('affiliated_user_id'),'paid_comission="0" and date_format(date_subscribtion, "%Y-%m")=date_format(NOW(), "%Y-%m") and  affiliated_user_id='.$val['user_id']);
			
			if(!empty($aAffiliatedUser)){
			$aUserInfo=$this->getUserInfo($val['user_id']);
			if($aUserInfo['subscribtion']=='1')
				$vTotalPayout=$vTotalPayout+$monthlyCommision;
			else if($aUserInfo['subscribtion']=='6')
				$vTotalPayout=$vTotalPayout+$yearlyCommision;
			}
		}
		return $vTotalPayout;
	}
	
	/* public function addAffiliatesInfo($sAffiliatesLink, $aParam) {
		
		$aAffilitesInfo = $this->getAffiliatesInfo ( $sAffiliatesLink );
		
		if ($aAffilitesInfo ['user_id'] > 0) {
			$created = $aAffilitesInfo ['created'] + $aParam ['created'];
			$accessed = intVal($aAffilitesInfo ['accesed']) + $aParam ['accesed'];
			
			$subscribtionMonthly = $aAffilitesInfo ['subs_month'] + $aParam ['subs_month'];
			$subscribtionYear = $aAffilitesInfo ['subs_year'] + $aParam ['subs_year'];
			$this->oDatabase->update ( 'affiliates_program', array ('accesed'=>$accessed,'created' => $created, 'subs_month' => $subscribtionMonthly, 'subs_year' => $subscribtionYear ), 'user_id=' . $aAffilitesInfo ['user_id'] );
		} else {
			$userid = $this->getParentUserIdAffiliates ( $sAffiliatesLink );
			if ($userid > 0) {
				$aParam ['user_id'] = $userid;
				$this->oDatabase->insert ( 'affiliates_program', array_keys ( $aParam ), array_values ( $aParam ) );
			}
		}
	
	} */
		public function getParentUserIdAffiliates($sAffiliatesLink){
			if(!empty($sAffiliatesLink)){
			$aUserInfo=$this->oDatabase->getRow('user_extra_data',array('user_id'),'aff_code="'.$sAffiliatesLink.'"');
			if($aUserInfo['user_id']>0)
			    return $aUserInfo['user_id'];
			else
				return 0;
			}else 
				return 0;
		}
		
		
		public function getAffiliatedLinkCode($vUserId){
			$vParentUserId=0;
			$sAffiliatedLink='';
			$aParentUser=$this->oDatabase->getRow('user_extra_data',array('affiliated_parent_user'),'user_id='.$vUserId);
			if(isset($aParentUser['affiliated_parent_user']) && $aParentUser['affiliated_parent_user']>0){
				$vParentUserId=$aParentUser['affiliated_parent_user'];
				$aAffiliatedLink=$this->oDatabase->getRow('user_extra_data',array('aff_code'),'user_id='.$vParentUserId);
				if(isset($aAffiliatedLink['aff_code']) && strlen($aAffiliatedLink['aff_code'])>0)
					$sAffiliatedLink=$aAffiliatedLink['aff_code'];
			}
			
			return $sAffiliatedLink;
		}
		
		
		
	public function getAffiliatesInfo($sAffiliatesLink){
		$aAffilitesData=array();$created=0;$subs_month=0;$subs_year=0;$vPayoutPaid=0;$totalActiveSubscribtion=0;
		//$userid=$this->getParentUserIdAffiliates($sAffiliatesLink);
		 $aAffilitesInfo=$this->oDatabase->getAll('affiliates_program',array('user_id','pay_active','date_created','date_subscribtion','created','subs_month','subs_year','affiliated_user_id','paid_comission'),'token="'.trim($sAffiliatesLink).'"');
         foreach($aAffilitesInfo as $val){
         	
         	if($val['created']=='1' && date("Y-m",strtotime($val['date_created'])) ==date("Y-m",time()))
         		$created++;
         	if($val['subs_month']=='1' && $val['pay_active']=='1' &&  date("Y-m",strtotime($val['date_subscribtion']))==date("Y-m",time()))
         		$subs_month++;
         	if($val['subs_year']=='1' && $val['pay_active']=='1' &&  date("Y-m",strtotime($val['date_subscribtion'])) ==date("Y-m",time()))
         		$subs_year++;
         	if($val['paid_comission']!='0' && $val['pay_active']=='1')
         		     $vPayoutPaid++;
         		
         }
         $totalActiveSubscribtion=$subs_month+$subs_year;
         if($totalActiveSubscribtion>0){
	         if($vPayoutPaid!=$totalActiveSubscribtion)
	         	$bPayoutPaid=0;
	         else 
	         	$bPayoutPaid=1;
         }else
         	$bPayoutPaid=0;
         	
         $aAffilitesData['created_count']=$created;
         $aAffilitesData['subs_count_month']=$subs_month;
         $aAffilitesData['subs_count_year']=$subs_year;
         $aAffilitesData['payout_status']=$bPayoutPaid;
		
         return $aAffilitesData;
	}
	public function checkUser($oGoogleInfo, $bDoNotCreateUser=0,$sAffiliatesLink='')
	{
		
		if(empty($oGoogleInfo->sub))
		   $aUser = $this->isUser($oGoogleInfo['sub']);
	    else
		   $aUser = $this->isUser($oGoogleInfo->sub);
		
		if(isset($aUser['user_id']) && $aUser['user_id']>0 && $aUser['is_active']==1)
			$vUserId = $aUser['user_id'];
		elseif($bDoNotCreateUser==0)
		if(!($aUser['is_active']==0 && $aUser['user_id']>0))
			$vUserId = $this->addUser($oGoogleInfo,$sAffiliatesLink);
	
		return $vUserId;
	}
	public function checkUser_old($oGoogleInfo, $bDoNotCreateUser=0,$sAffiliatesLink='')
	{
		$aUser = $this->isUser($oGoogleInfo->id);
		if(isset($aUser['user_id']) && $aUser['user_id']>0 && $aUser['is_active']==1)
			$vUserId = $aUser['user_id'];
		elseif($bDoNotCreateUser==0)
			if(!($aUser['is_active']==0 && $aUser['user_id']>0))
				$vUserId = $this->addUser($oGoogleInfo,$sAffiliatesLink);
		
		return $vUserId;
	}
	
	public function isUser($sGoogleUserId)
	{
		$aUser = $this->oDatabase->getRow('users', array('user_id','is_active'), 'google_id="'.$sGoogleUserId.'"');
		
		return $aUser;
	}
	
	public function getUserInfo($vUserId)
	{
		return $this->oDatabase->getRow('users', array('picture','subscribtion','first_name','last_name', 'email','google_id','user_type'), 'user_id='.$vUserId.' and is_active="1"');
	}
	
	public function getProAccounts()
	{
		return $this->oDatabase->getAll('users', array('user_id'), 'subscribtion=1');
	}
	
	public function getAllActiveUsers()
	{
		$oAuth = $this->Vista->Auth();
		$aActiveUsers = array();
		
		$aUsers = $this->oDatabase->getAll('users', array('user_id'), 'is_active="1"');
		foreach($aUsers as $valUser)
			if( $oAuth->getLastLogin($valUser['user_id']) > (time()-10368000))
				$aActiveUsers[] = array('user_id'=>$valUser['user_id']);
		
		return $aActiveUsers;
	}
	
	
//[end]
}

?>