using UnityEngine;
using System.Collections;
using System.Collections.Generic;

public class G37_FeverGame : FeverGameBase
{
	public static G37_FeverGame Instance;
	public WheelController_Grid WheelControl;
	public MobileMovieTexture MovieObj;
#if UNITY_WEBPLAYER
	public MovieTexture movieTexture;
#endif
	public GameObject MoviePlane;
	public GameObject MoviePlane_FB;
	
	public GameObject[] BingoEffects;
	
	public GameObject[] FireCrackerL;	// 0: path, 1: eat anim, 2: fire particle
	public GameObject[] FireCrackerR;
	
	public ParticleSystem[] fireParticles;
	
	public GameObject ZombieComeIn;
	public PlayAnimStepByStep AllSameVideoParticle;
	
	public GameObject RespinLabel;
	
	private const string Anim_fire = "app_ZB_FCs_fire";  
    private const string Anim_idle = "app_ZB_FCs_idle";  
    private const string Anim_down = "app_ZB_FCs_down";  
    private const string Anim_once = "app_ZB_FCs_once";  
	
	private const string Anim_crackfire = "app_zb_firecrack_fire";  
    private const string Anim_crackfireonce = "app_zb_firecrack_once";  
	
	private const string Anim_ZombieIn = "in";
	private const string Anim_ZombieOut = "out";
	
	private enum FireCrackType
	{
		fire = 0,
		once
	}
	
	private bool _bIsEnding = false;	
	private bool _bIsStarted = false;	
	private bool m_bIsNetMode = false;
	private bool m_bIsClientCheckFever = true;
	
	private int _wheelAmount = 15;
	private int _symbolAmount = 3;
	private int _wheelRows = 3;
	private int _wheelColumns = 5;
	
	private Dictionary<int, object> m_iBingoLine = new Dictionary<int, object>();	
	
	private enum FeverState
	{ 	
		NONE = -1, 
		INIT, 
		RECOVERY, 
		COMMENT, 
		BEGINANIM,  
		SPIN, 
		WAITING,
		ANIMATION,
		STOP, 
		FEATURE, 
		SHOWLINE, 
		RESULT, 
		END, 
		TIMERESET = 50,
		DELAY = 100, 
		SUSPEND = 200 
	};
	
	private enum FeverDataKind
	{ 	
		NONE = -1,
		NEXT = 2, 
		RECOVERY = 3, 
		RESULT = 4,
		INIT = 5
	};
	
	enum NextDataKey
	{ 	
		NONE = -1, 
		WHEEL = 1, 
		LOCK = 2, 
		BINGOLINE = 3, 
		TOTALWIN = 4
	};
	
	private enum ResultDataKey
	{ 
		NONE = -1, 
		WHEEL = 1, 
		LOCK = 2, 
		BINGOLINE = 3, 
		TOTALWIN = 5
	}
	private enum RecoverDataKey
	{ 
		NONE = -1, 
		WHEEL = 1, 
		LOCK = 2
	}
	
	#region Override Fever game properties 
	public override bool IsEnding {	get{ return _bIsEnding; } }
	public override bool IsClientCheckFever { get{ return m_bIsClientCheckFever; } }
	#endregion	
	
	private FeverState _state = FeverState.NONE;
	
	private int[] m_iFeverIndexAry;
	private int[] m_iResultAry;
	private int[] m_iShowLineIDAry;
	private int[,] m_iShowBingoAry;
	
	private int m_iSpinTimes = 0;
	private int m_iRespinTimes = 0;
	private int m_iStopCount = 0;
	private double m_dWin = 0;
	private double m_dTotalWin = 0;
	private bool m_bIsReceiveData = false;
	private int m_iFeverDataKind = -1;
	
	private FeverState m_nNextState = FeverState.NONE;
	
	private List<int> m_iFeverIndexList = new List<int>();
	private List<int> m_iNotFeverIndexList = new List<int>();
	private List<int> m_iNotFeverIndexForStopList = new List<int>();
	
	private float m_fDelay;
	private Timer m_timer = new Timer();

	private bool m_bCanPlay = false;
	
	private int m_iTriggerID = 0;
	
//*[Threads]
	void Awake ()
	{
		//_IMainGameHost = MainGameAgent.Instance.getMainGameHostInstance();
		StartCoroutine( IntiFireCrack() );
		m_bIsNetMode = GameManager.m_bIsNetworkMode;
		MoviePlane.SetActive(false);
		MoviePlane_FB.SetActive(false);
		SetVideoUrl("ZombieNY_AllSame.ogv");
	}

	void Start ()
	{
		Instance = this;
		foreach( GameObject bingoEffect in BingoEffects )
			bingoEffect.SetActive(false);
		ZombieComeIn.SetActive(false);
		RespinLabel.SetActive(false);
	}
	
	void Update ()
	{
		// Update Fever game process.
		GameProcess(_state);
	#if UNITY_WEBPLAYER
		/*if (m_bCanPlay && movieTexture.isReadyToPlay) 
		{
			movieTexture.Play();
			m_bCanPlay = false;
			MoviePlane_FB.SetActive(true);
			MoviePlane_FB.audio.Play();
			Delay( 5.0f, FeverState.SPIN );
		}*/
	#endif
	}
	
	void OnDestroy ()
	{
		NetworkConnt.Instance.ReceiveFeverNextLevelDataEvent -= ReceiveFeverNextLevelDelegate;	
	}
	

//*[Methods]
	private void GameProcess (FeverState nState)
	{
		switch(nState)
		{
			case FeverState.NONE:
			{
				
			} break;
				
			case FeverState.INIT:
			{
				RespinLabel.SetActive(true);
				//if( CheckClientHaveFever( m_iResultAry ) )
				PlayFireCrack(FireCrackType.fire);
				//MoviePlay();
				//if( !m_bIsNetMode )
				Delay( 5.0f, FeverState.SPIN );
			} break;
			
			case FeverState.WAITING:
			{
				m_iStopCount = 0;
				for( int i = 0; i < _wheelAmount; i ++ )
				{
					if( WheelControl.m_WheelAry[i].Status == Wheel_Grid.State.Stop )
						m_iStopCount ++;
				}
				if( m_iStopCount == _wheelAmount )
				{
					if( m_bIsNetMode )
					{
						if( m_iFeverDataKind == (int)FeverDataKind.RESULT )
							Delay( 1.0f, FeverState.SHOWLINE );
						else
						{
							Delay( 1.0f, FeverState.ANIMATION );
							//m_timer.Reset();
						}
					}
					else
					{
						if(m_iRespinTimes > 0)
							SwitchState(FeverState.ANIMATION);
						else
							SwitchState(FeverState.SHOWLINE);
					}
				}
			} break;
			
			case FeverState.BEGINANIM:
			{
				
			} break;
				
			case FeverState.STOP:
			{
				
			} break;
			
			case FeverState.FEATURE:
			{
			
			} break;
	
			case FeverState.SUSPEND:
			{
			
			} break;
			
			case FeverState.TIMERESET:
			{
				m_timer.Reset();
				SwitchState( FeverState.DELAY );
			} break;
			
			case FeverState.DELAY:
			{
				if( m_timer.IsAbove(m_fDelay, true) ) 
				{
					SwitchState(m_nNextState);		
					m_timer.Reset();
				}
			} break;
		}
	}
	
	private void SwitchState (FeverState State)
	{
		_state = State;
		switch(State)
		{
			case FeverState.SUSPEND:
			{
				
			} break;
			case FeverState.RECOVERY:
			{
				if( m_iFeverIndexList != null && m_iNotFeverIndexList != null )
					Delay( 2.0f, FeverState.SPIN );
			} break;
			case FeverState.SPIN:
			{
				Spin();
				if( !m_bIsNetMode )
				{
					m_iSpinTimes ++;
					FakeServerSendNextLevel( m_iSpinTimes );
					Delay(1.0f, FeverState.STOP);
				}
				else
				{
					m_iNotFeverIndexForStopList.Clear();
					for( int i = 0; i < m_iNotFeverIndexList.Count; i++ )
						m_iNotFeverIndexForStopList.Add(m_iNotFeverIndexList[i]);
					SendCmdNextLevel(0);
				}
			} break;
			case FeverState.STOP:
			{
				Stop();
				if( !m_bIsNetMode )
					CheckClientHaveFever( GetReelResultAry(m_iResultAry) );
				SwitchState( FeverState.WAITING );
			} break;
			case FeverState.SHOWLINE:
			{	
				if(!m_bIsNetMode) m_iBingoLine = GetBingoAndWinNum( GetReelResultAry(m_iResultAry) );
			
				if( m_iBingoLine == null || !m_bIsNetMode)
				{
					StartCoroutine(MoviePlay());
					return;
				}
			// Display how many line player is bingo.
				// Server netowrk mode
				if(m_bIsNetMode) {					
					m_iShowLineIDAry = m_iBingoLine[0] as int[];
					m_iShowBingoAry = m_iBingoLine[1] as int[,];	
				}
				// Stand-alone mode
				else {								
					/*m_dWin = (double)m_iBingoLine[2];
					m_dTotalWin += m_dWin;*/
			
					//Get win bingo line data
					m_iShowBingoAry = m_iBingoLine[1] as int[,];
					m_iShowLineIDAry = GetLineShowArray((int)m_iBingoLine[0], m_iShowBingoAry);	
					m_dTotalWin = (double)m_iBingoLine[2];
				}

				if( m_dTotalWin > 0 )
					SetWinNum(m_dTotalWin);
			
				SetBingoLineArray(m_iShowLineIDAry, m_iShowBingoAry);		
				//SetWinNum(m_dTotalWin);
				ShowBingoAndWinNum(m_dTotalWin);	
			
				Delay (3.0f, FeverState.RESULT);
			} break;
			case FeverState.ANIMATION:
			{
				PlayFireCrack(FireCrackType.once);
				Delay( 6.0f, FeverState.SPIN );
			} break;
			case FeverState.RESULT:
			{
			 	StopShowBingo();
				SwitchState( FeverState.END );
			} break;
			
			case FeverState.END:
			{
				MovieStop();
				RespinLabel.SetActive(false);
				StartCoroutine( IntiFireCrack() );
				AllSameVideoParticle.Stop();
				_bIsEnding = true;
				NetworkConnt.Instance.ReceiveFeverNextLevelDataEvent -= ReceiveFeverNextLevelDelegate;
				GameReset();
			} break;
		}
	}
	
	private void SetVideoUrl(string videoName)
	{
		#if UNITY_WEBPLAYER
			MoviePlane_FB.renderer.material.mainTexture = movieTexture;
			MoviePlane_FB.transform.renderer.material.mainTexture = movieTexture;
			//renderer.material.mainTexture = movieTexture;
			MoviePlane_FB.audio.clip = movieTexture.audioClip;
		#elif (UNITY_ANDROID || UNITY_IOS || UNITY_STANDALONE) && UNITY_4_6_1
			//MoviePlane.audio.clip = MovieObj.audio;
		#endif
	}
	
	private IEnumerator IntiFireCrack()
	{
		FireCrackerL[1].renderer.materials[1].SetTextureOffset("_MainTex", new Vector2(0, 0));
		FireCrackerR[1].renderer.materials[1].SetTextureOffset("_MainTex", new Vector2(0, 0));
		FireCrackerL[2].SetActive(false);
		FireCrackerR[2].SetActive(false);
		
		FireCrackerL[0].animation.Rewind();
		FireCrackerR[0].animation.Rewind();
		FireCrackerL[0].animation.Play( Anim_down );
		FireCrackerR[0].animation.Play( Anim_down );
		yield return new WaitForSeconds(2f);
		FireCrackerL[0].animation.Rewind();
		FireCrackerR[0].animation.Rewind();
		FireCrackerL[0].animation.Play( Anim_idle );
		FireCrackerR[0].animation.Play( Anim_idle );
	}
	
	private void PlayFireCrack(FireCrackType type)
	{
		switch(type)
		{
		case FireCrackType.fire:
		{	
			StartCoroutine(PlayZBComeInAnim(4.0f));
			foreach( ParticleSystem fireParicle in fireParticles )
			{
				fireParicle.startDelay = 0f;
			}
			FireCrackerL[0].animation.Rewind();
			FireCrackerR[0].animation.Rewind();
			FireCrackerL[0].animation.Play( Anim_fire );
			FireCrackerR[0].animation.Play( Anim_fire );
			
			FireCrackerL[1].animation.Rewind();
			FireCrackerR[1].animation.Rewind();
			FireCrackerL[1].animation.Play( Anim_crackfire );
			FireCrackerR[1].animation.Play( Anim_crackfire );
			
			FireCrackerL[2].SetActive(false);
			FireCrackerR[2].SetActive(false);
			FireCrackerL[2].SetActive(true);
			FireCrackerR[2].SetActive(true);
		}break;
		case FireCrackType.once:
		{
			StartCoroutine(PlayZBComeInAnim(5.0f));
			foreach( ParticleSystem fireParicle in fireParticles )
			{
				fireParicle.startDelay = 2f;
			}
			FireCrackerL[0].animation.Rewind();
			FireCrackerR[0].animation.Rewind();
			FireCrackerL[0].animation.Play( Anim_once );
			FireCrackerR[0].animation.Play( Anim_once );
			
			FireCrackerL[1].animation.Rewind();
			FireCrackerR[1].animation.Rewind();
			FireCrackerL[1].animation.Play( Anim_crackfireonce );
			FireCrackerR[1].animation.Play( Anim_crackfireonce );
			
			FireCrackerL[2].SetActive(false);
			FireCrackerR[2].SetActive(false);
			FireCrackerL[2].SetActive(true);
			FireCrackerR[2].SetActive(true);
		}break;
		}
	}
	
	private IEnumerator PlayZBComeInAnim( float _delay )
	{
		ZombieComeIn.SetActive(true);
		ZombieComeIn.animation.Rewind();
		ZombieComeIn.animation.Play(Anim_ZombieIn);
		yield return new WaitForSeconds(_delay);
		ZombieComeIn.animation.Rewind();
		ZombieComeIn.animation.Play(Anim_ZombieOut);
		yield return new WaitForSeconds(2f);
		ZombieComeIn.SetActive(false);
	}

	private IEnumerator MoviePlay()
	{
	#if UNITY_WEBPLAYER
		if(movieTexture.isReadyToPlay)
			movieTexture.Play();
		else
		{
			StartCoroutine(MoviePlay());
			yield return null;
		}
		yield return new WaitForSeconds(0.5f);
		MoviePlane_FB.SetActive(true);
		MoviePlane_FB.audio.Play();
		m_bCanPlay = true;
		AllSameVideoParticle.Reset();
		AllSameVideoParticle.Play();
		Delay( 6.0f, FeverState.END );
	#elif (UNITY_ANDROID || UNITY_IOS || UNITY_STANDALONE) && UNITY_4_6_1
		MovieObj.Play();
		yield return new WaitForSeconds(0.5f);
		MoviePlane.SetActive(true);
		MoviePlane.audio.Play();
		AllSameVideoParticle.Reset();
		AllSameVideoParticle.Play();
		Delay( 5.5f, FeverState.END );
		//Delay( 5.5f, FeverState.END );
		/*yield return new WaitForSeconds(4.5f);
		MovieObj.Play*/
	#endif
	}
	private void MovieStop()
	{
	#if UNITY_WEBPLAYER
		movieTexture.Stop();
		MoviePlane_FB.SetActive(false);
		MoviePlane_FB.audio.Stop();
	#elif (UNITY_ANDROID || UNITY_IOS || UNITY_STANDALONE) && UNITY_4_6_1
		MovieObj.Stop();
		MoviePlane.audio.Stop();
		MoviePlane.SetActive(false);
	#endif
	}

	private Dictionary<int, object> GetBingoAndWinNum (int[] nResultAry)
	{
		return GameData.Instance.GetBingoLineData_Grid(nResultAry, iFeverID, _wheelRows, _wheelColumns, _symbolAmount);
	}
	
	private int[] GetLineShowArray (int showCount, int[,] checkArray)
	{
		int[] showLineIDArray = new int[showCount];
		
		int addCount = 0;
		for(int i = 0; i < m_AwardControl.Lines.Length; ++i)
		{
			bool[] bShowFrameArray;
			if(checkArray[i,0] != -1 && addCount < showCount)
			{
				showLineIDArray[addCount] = i;				
				++addCount;
				bShowFrameArray = m_AwardControl.GetAwardFrameMatchList(i);
				if (bShowFrameArray != null)
				{
					for ( int j = 0; j < bShowFrameArray.Length ; j++ )
					{
						if ( checkArray[i,j] != -1)
						{
							bShowFrameArray[j] = true;
						}
						else
						{
							bShowFrameArray[j] = false;
						}
					}
				}
			}
		}
		return showLineIDArray;
	}
	
	private void SetBingoLineArray (int[] iShowLineAry, int[,] iCheckAry)
	{
		// Set bingo line symbol 
		m_AwardControl.AwardLineIDAry = iShowLineAry;	
		// Set bingo line symbol sound.
		int[,] resultAry = new int[_wheelRows,_wheelColumns];
		int[] ReelResultAry = GetReelResultAry(m_iResultAry);
		for(int i = 0; i < ReelResultAry.Length; ++i)
		{
			int wheel = i / _wheelColumns;
			int index = i % _wheelRows;
			resultAry[index, wheel] = ReelResultAry[i];
		}
		
		m_AwardControl.AwardLineSymbolAry = GameData.Instance.GetSymbolIDWithBingoLineID_Grid(iShowLineAry, resultAry, iCheckAry);
	}
	
	private void StopShowBingo ()
	{
		SetWinNum(m_dTotalWin);
		m_AwardControl.StopAwardDisplaySequence();
	}
	
	private void SetWinNum (double dMoney)
	{
		if(GameData.Instance.IsTournament) {
			SetTourSubWinScore( dMoney);	
		}
		else {
			GameData.Instance.WinNum = dMoney;	
		}
		
		m_AwardControl.UpdateWinNumbers (true);
	}
	
	private void ShowBingoAndWinNum (double dWinNum)
	{
		if(dWinNum < 0) return;
		
		m_AwardControl.loopShowAward = false;
		m_AwardControl.showScatterFrames = false;
		m_AwardControl.showLineAwardFrames = false;
		
		m_AwardControl.StartAwardDisplaySequence();
	}
			
	private void Spin()
	{
		for( int i = 0; i < m_iNotFeverIndexList.Count; i ++ )
		{
			WheelControl.SpinSingle( m_iNotFeverIndexList[i], WheelController_Grid.SpinSpeed.Slow, Wheel_Grid.RotateDirection.Down );
		}
	}
	
	private void Stop()
	{
		WheelControl.StopRotatingWheels( m_iNotFeverIndexForStopList, m_iResultAry, WheelController_Grid.StopMode.Normal, m_iFeverIndexList );
			//WheelControl.StopSingle( m_iNotFeverIndexList[i], WheelContr
	}
	
	private void GameReset()
	{
		m_iRespinTimes = 5;
		m_iSpinTimes = 0;
		m_dWin = 0;
		m_dTotalWin = 0;
	}
	
	#region For stand-alone version override fevergame function.
	
	public override bool CheckClientHaveFever (int[] iResultAry)
	{
		/*int nFeverID = 0;
		int nRow = 0;
		for(int wheel = 2; wheel < cons_nFeverWheel; ++wheel)
		{
			for(int index = 1; index < (cons_nSymbolLength - 1); ++index)
			{
				int	symbolID = (wheel * cons_nWheelLength) + index;	//Get edit the Symbol ID 				
				if( nResultAry[symbolID] == FeverSymbolID[nFeverID] ) {
					m_nFeverIndexAry.Add (symbolID);
					++nRow;
				}
			}	
			++nFeverID;			
		}	
		
		if(nRow >= cons_nQualifica) return true;*/
		bool bIsFever = false;
		int iTarget = iResultAry[1];
		m_iTriggerID = iTarget;
		m_iFeverIndexList.Clear();
		m_iNotFeverIndexList.Clear();
		m_iNotFeverIndexForStopList.Clear();

		if( iResultAry[1] == iTarget && iResultAry[7] == iTarget && iResultAry[13] == iTarget )
			bIsFever = true;
		
		for( int wheel = 0; wheel < _wheelAmount; wheel ++ )
		{
			if( iResultAry[wheel] != iTarget)
				/*m_iFeverIndexList.Add(wheel);
			else*/
			{
				m_iNotFeverIndexList.Add(wheel);
				m_iNotFeverIndexForStopList.Add(wheel);
			}
		}
		
		return bIsFever;
	}
	
	public override int[] GetClientAssignFeverData()
	{
		int[] iFakeData = new int[]
		{
			18, 10, 11, 18, 10, 11, 18, 12, 11,
			11, 11, 12, 18, 13, 13, 18, 13, 13,
			11, 12, 12, 18, 10, 13, 18, 14, 13,
			11, 13, 12, 18, 15, 13, 18, 15, 13,
			18, 14, 11, 18, 10, 11, 18, 16, 11
		};
		return iFakeData;
	}
	#endregion
	
	#region Override Fever game functions.	
	public override void EnterFeverGame(IDictionary dataDic)
	{	
		
		//Register network event!!!		
		_bIsEnding = false;
		NetworkConnt.Instance.ReceiveFeverNextLevelDataEvent += ReceiveFeverNextLevelDelegate;
		
		if(m_bIsNetMode) 
		{		
			if(dataDic != null && dataDic.Count > 0) {
				RecoverGame(dataDic);		
				SwitchState( FeverState.RECOVERY );
			}	
			else {
				SendCmdNextLevel(0);
				SwitchState( FeverState.SUSPEND );
			}
		}
		else //Assign dat for client!!	
		{
			#if DEBUG_MODE
			Debug.Log ("ENTER Fever Game - Stand alone!!");
			#endif
			m_iResultAry = GetClientAssignFeverData();	
			SwitchState( FeverState.INIT );
		}	
	}
	
	
	
	
	#endregion	
	
//*[Network Section]
	private void ReceiveFeverNextLevelDelegate (object sender, System.EventArgs e)
	{
	#if DEBUG_MODE
		Debug.Log ("ENTER_FEVER_NEXT_LEVEL ReceiveData");
	#endif
		
		NetworkConnt.ReceiveFeverNextLevelArgs args = e as NetworkConnt.ReceiveFeverNextLevelArgs;
		IList lFeverData = (IList)args.m_FeverData["fever_map"];
		
		if(lFeverData != null) {
			m_bIsReceiveData = false;
			int nFeverDataKind = System.Convert.ToInt16( args.m_FeverData["fever_id"] );
			GetServerDataByKind(nFeverDataKind, lFeverData);
			//Debug.Log("This receiveData respin: " + m_nRespin);
			
			m_iFeverDataKind = nFeverDataKind;
			
			if( nFeverDataKind == (int)FeverDataKind.INIT )
				Delay(1.0f, FeverState.INIT);	
			else
				Delay(1.0f, FeverState.STOP);
			
		}
		else {
			Debug.LogError("FeverData error");	
		}
		
	}
	
	private void FakeServerSendNextLevel ( int spinTimes )
	{	
		// client create wheel data 
		//m_iResultAry = GameData.Instance.getStopReelSymbol_Grid( _wheelRows, _wheelColumns, _symbolAmount );
		switch( spinTimes )
		{
			case 1:
			{
				int[] iFakeData = new int[]
				{
					18, 10, 11, 18, 10, 11, 18, 12, 11,
					11, 10, 12, 18, 13, 13, 18, 10, 13,
					11, 12, 12, 18, 10, 13, 18, 14, 13,
					11, 10, 12, 18, 15, 13, 18, 10, 13,
					18, 14, 11, 18, 10, 11, 18, 16, 11
				};	
				m_iRespinTimes = 5;
				m_iResultAry = iFakeData;
			}break;
			case 2:
			{
				int[] iFakeData = new int[]
				{
					18, 10, 11, 18, 10, 11, 18, 12, 11,
					11, 10, 12, 18, 13, 13, 18, 10, 13,
					11, 10, 12, 18, 10, 13, 18, 10, 13,
					11, 10, 12, 18, 15, 13, 18, 10, 13,
					18, 14, 11, 18, 10, 11, 18, 16, 11
				};	
				m_iResultAry = iFakeData;
			}break;
			case 3:
			{
				int[] iFakeData = new int[]
				{
					18, 10, 11, 18, 10, 11, 18, 12, 11,
					11, 10, 12, 18, 10, 13, 18, 10, 13,
					11, 10, 12, 18, 10, 13, 18, 10, 13,
					11, 10, 12, 18, 10, 13, 18, 10, 13,
					18, 14, 11, 18, 10, 11, 18, 16, 11
				};	
				m_iResultAry = iFakeData;
			}break;
			case 4:
			{
				int[] iFakeData = new int[]
				{
					18, 10, 11, 18, 10, 11, 18, 10, 11,
					11, 10, 12, 18, 10, 13, 18, 10, 13,
					11, 10, 12, 18, 10, 13, 18, 10, 13,
					11, 10, 12, 18, 10, 13, 18, 10, 13,
					18, 14, 11, 18, 10, 11, 18, 10, 11
				};	
				m_iResultAry = iFakeData;
			}break;
			case 5:
			{
				int[] iFakeData = new int[]
				{
					18, 10, 11, 18, 10, 11, 18, 10, 11,
					11, 10, 12, 18, 10, 13, 18, 10, 13,
					11, 10, 12, 18, 10, 13, 18, 10, 13,
					11, 10, 12, 18, 10, 13, 18, 10, 13,
					18, 10, 11, 18, 10, 11, 18, 10, 11
				};	
				m_iRespinTimes = 0;
				m_iResultAry = iFakeData;
			}break;
			
		}
		int[] _iResultAry = GetReelResultAry(m_iResultAry);
		int iTarget = _iResultAry[1];
		m_iFeverIndexList.Clear();
		
		for( int wheel = 0; wheel < _wheelAmount; wheel ++ )
		{
			if( _iResultAry[wheel] == iTarget)
				m_iFeverIndexList.Add(wheel);
		}
	}
	
	// 將整個牌面資料轉換成剩結果牌面
	private int[] GetReelResultAry(int[] AllReelArray)
	{
		int[] ResultArray = new int[_wheelAmount];
		for(int i = 0; i < _wheelAmount; i ++ )
		{
			ResultArray[i] = AllReelArray[i * _symbolAmount + (int)(_symbolAmount/2)];
		}
		return ResultArray;
	}
	
	private void Delay (float fTime, FeverState NextState)
	{
		m_nNextState = NextState;
		m_fDelay = fTime;
		//m_timer.Reset();
		SwitchState(FeverState.TIMERESET);
	}
	
	private void RecoverGame (IDictionary dicData)
	{
		IList lData = (IList)dicData["fever_map"];
		
		if(lData == null || lData.Count <= 0) {
			Debug.Log (" ===== No define recovery data can use!!!!");
			return;
		}
		
		SetRecoverData(lData);
	}
	
	private void SendCmdNextLevel (int feverID)
	{
	#if DEBUG_MODE
		Debug.Log ("ENTER_FEVER_NEXT_LEVEL");
	#endif
		
		if(GameData.Instance.IsTournament)
			NetworkConnt.Instance.sendTourFeverGameNextLevel(feverID, PlayerData.Instance.m_iTicketSerialID);
		else
			NetworkConnt.Instance.sendFeverGameNextLevel(feverID);
	}
	
	private void GetServerDataByKind (int nDataKind, IList lData)
	{
		
		switch( (FeverDataKind)nDataKind )
		{
			case FeverDataKind.NEXT: 	 { SetNextData(lData);	  } break;
			case FeverDataKind.INIT: 	 { SetNextData(lData);	  } break;
			case FeverDataKind.RECOVERY: { SetRecoverData(lData); } break;
			case FeverDataKind.RESULT:	 { SetResultData(lData);  } break;
			
			default: {
				Debug.LogError("* This FeverDataKind type not define!!!");
			} break;
		}
		m_bIsReceiveData = true;
	}
	
	#region Pares Server DATA
	
	private void SetNextData (IList lData)
	{
		foreach (IDictionary argDic in lData)
		{
			int nKey = System.Convert.ToInt32 (argDic["key"]);
			
			switch( (NextDataKey)nKey )
			{
				case NextDataKey.WHEEL:
				{
					m_iResultAry = FeverData_Grid.Instance.GetWheelDataToArray ((IList)argDic["value"]);
				} break;
				case NextDataKey.LOCK:
				{
					m_iFeverIndexAry = FeverData_Grid.Instance.GetFeverDataToArray ((IList)argDic["value"]);
				
					m_iFeverIndexList.Clear();
					m_iNotFeverIndexList.Clear();
					
					for( int wheel = 0; wheel < _wheelAmount; wheel ++ )
					{
						if( m_iFeverIndexAry[wheel] > 0)
						{
							m_iTriggerID = m_iFeverIndexAry[wheel];
							m_iFeverIndexList.Add(wheel);
						}
						else
							m_iNotFeverIndexList.Add(wheel);
					}
				} break;
			}
		}
	}
	
	private void SetResultData (IList lData)
	{
		foreach (IDictionary argDic in lData)
		{
			int nKey = System.Convert.ToInt32 (argDic["key"]);
			
			switch( (ResultDataKey)nKey )
			{
				case ResultDataKey.WHEEL:
				{
					m_iResultAry = FeverData_Grid.Instance.GetWheelDataToArray ((IList)argDic["value"]);
				} break;
				
				case ResultDataKey.LOCK:
				{
					m_iFeverIndexAry = FeverData_Grid.Instance.GetFeverDataToArray ((IList)argDic["value"]);
				} break;
				
				case ResultDataKey.BINGOLINE:
				{
					m_iBingoLine = FeverData_Grid.Instance.GetBingoLineArray ((IList)argDic["value"]);
				} break;
				
				case ResultDataKey.TOTALWIN:
				{
					m_dTotalWin = System.Convert.ToDouble (argDic["value"]);
				} break;
			}
		}
	}
	
	private void SetRecoverData (IList lData)
	{
		foreach(IDictionary argDic in lData)
		{
			int nKey = System.Convert.ToInt32 ( argDic["key"]);	
			switch((RecoverDataKey)nKey)
			{
				case RecoverDataKey.WHEEL:
				{
					m_iResultAry = FeverData_Grid.Instance.GetWheelDataToArray ((IList)argDic["value"]);
				} break;
				
				case RecoverDataKey.LOCK:
				{
					m_iFeverIndexAry = FeverData_Grid.Instance.GetFeverDataToArray ((IList)argDic["value"]);
				
					m_iFeverIndexList.Clear();
					m_iNotFeverIndexList.Clear();
					
					for( int wheel = 0; wheel < _wheelAmount; wheel ++ )
					{
						if( m_iFeverIndexAry[wheel] > 0)
						{
							m_iTriggerID = m_iFeverIndexAry[wheel];
							m_iFeverIndexList.Add(wheel);
						}
						else
							m_iNotFeverIndexList.Add(wheel);
					}
				} break;		
			}
			
		}
	}
	
	#endregion
	
	#region Tour Sub Win
	void OpenTourSubWinObj (bool bEnable)
	{
		if(TourSceneManager.Instance != null)
			TourSceneManager.Instance.OpenTourSubWinObj(bEnable);
	}
	
	void SetTourSubWinScore (double dScore)
	{
		if(TourSceneManager.Instance != null)
			TourSceneManager.Instance.SetTourSubWinScore(dScore);
	}
	
	void SetTourSubWinScoreToZero ()
	{
		if(TourSceneManager.Instance != null)
			TourSceneManager.Instance.SetTourSubWinScoreToZero();
	}		
	#endregion
}
