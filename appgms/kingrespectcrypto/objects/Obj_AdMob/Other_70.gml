/// @description AdMob event handlers

// We do an early exit if the 'async_load' map doesn't contain a "type" key.
if(!ds_map_exists(async_load, "type"))
	exit;

show_debug_message("AdMob: " + json_encode(async_load));

// We switch on the type of the event being fired
switch(async_load[?"type"])
{

	// AdMob_Initialize finished
	case "AdMob_OnInitialized":
		// At this point the AdMob API succeeded to initialize.
		// We use this event to load both the interstitial/rewarded video ads.
		//AdMob_Interstitial_Load();
		//AdMob_RewardedVideo_Load();
		global.CarregouInterstitial = true;
		AdMob_Banner_Create(AdMob_Banner_ADAPTIVE,true);
		break;
	
	// AdMob_Banner_Create succeeded
	case "AdMob_Banner_OnLoaded": 
		// At this point the banner ad succeeded to be created.
		show_debug_message("Admob banner carregado");
		break;
	
	// AdMob_Banner_Create failed
	case "AdMob_Banner_OnLoadFailed":
		// At this point the banner ad failed to be created.
		AdMob_Banner_Create(AdMob_Banner_ADAPTIVE,true);
		break;
	
	// AdMob_Interstitial_Load succeeded
	case "AdMob_Interstitial_OnLoaded":
		// At this point the interstitial ad succeeded to load.
		show_debug_message("Admob Interstitial Carregado");
		AdMob_Interstitial_Show();
		break;
	
	// AdMob_Interstitial_Load failed
	case "AdMob_Interstitial_OnLoadFailed":
		// At this point the interstitial ad failed to load.
		show_debug_message("Admob Interstitial Fail");
		global.CarregouInterstitial = false;
		AdMob_Interstitial_Load(); // This can create an infinite loop if load always fails!!
		break;
	
	// AdMob_Interstitial_Show succeeded
	case "AdMob_Interstitial_OnFullyShown":
		// At this point the interstitial ad succeeded to show.
		show_debug_message("Admob Interstitial OnFullyShown");
		break;

	// AdMob_Interstitial_Show failed
	case "AdMob_Interstitial_OnShowFailed":
		// At this point the interstitial ad failed to show.
		// Here we use this event to load the interstitial ad again (it could be a load problem).
		show_debug_message("Admob Interstitial Fail 2");
		AdMob_Interstitial_Load();
		break;
	
	// AdMob_Interstitial got dismissed
	case "AdMob_Interstitial_OnDismissed":
		// At this point the interstitial just got dismissed.
		// Here we use this event to load the next interstitial ad.
		show_debug_message("Admob Interstitial Dismissed");
		//AdMob_Interstitial_Load();
		break;
	
	// AdMob_RewardedVideo_Load succeeded
	case "AdMob_RewardedVideo_OnLoaded":
		// At this point the rewarded video succeeded to load.
		break;

	// AdMob_RewardedVideo_Load failed
	case "AdMob_RewardedVideo_OnLoadFailed":
		// At this point the rewarded video failed to load.
		//AdMob_RewardedVideo_Load() // This can create an infinite loop if load always fails!!
		break;
	
	// AdMob_RewardedVideo_Show succeeded
	case "AdMob_RewardedVideo_OnFullyShown":
		// At this point the rewarded video succeeded to show.
		break;
	
	// AdMob_RewardedVideo_Show failed
	case "AdMob_RewardedVideo_OnShowFailed":
		// At this point the rewarded video failed to show.
		// Here we use this event to load the rewarded video again (it could be a load problem).
		//AdMob_RewardedVideo_Load();
		break;
	
	// AdMob_RewardedVideo got dismissed
	case "AdMob_RewardedVideo_OnDismissed":
		// At this point the rewarded video just got dismissed.
		// Here we use this event to load the next rewarded video.
		//AdMob_RewardedVideo_Load();
		break;
	
	// AdMob_RewardedVideo triggered reward event
	case "AdMob_RewardedVideo_OnReward":
		// At this point you can reward the user.
		//show_message_async("User Earned Reward");
		break;
}

