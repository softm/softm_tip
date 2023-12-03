package com.entropykorea.ewire;

import android.content.Context;
import android.media.AudioManager;
import android.media.SoundPool;
import android.media.ToneGenerator;

public class eWireSound {
	
	public eWireSound() {
		
	}
	
	public static void playOk( Context ctx ) {
		SoundPool sound_pool;
		int sound_ok;
		float sound_volume;
		
		AudioManager audioManager = (AudioManager) ctx.getSystemService(ctx.AUDIO_SERVICE);
		sound_volume = (float) audioManager.getStreamVolume(AudioManager.STREAM_MUSIC);
		sound_pool = new SoundPool( 1, AudioManager.STREAM_MUSIC, 0 );
		sound_ok = sound_pool.load( ctx, R.raw.downok, 1 );
		sound_pool.play( sound_ok, sound_volume, sound_volume, 0, 0, 1f );
		
	}

	public static void playBeep( Context ctx ) {
		float sound_volume;
		int sound_max_volume;
		float volume;
		
		AudioManager audioManager = (AudioManager) ctx.getSystemService(ctx.AUDIO_SERVICE);
		sound_volume = (float) audioManager.getStreamVolume(AudioManager.STREAM_DTMF);
		sound_max_volume = (int) audioManager.getStreamMaxVolume(AudioManager.STREAM_DTMF);
		
		volume = sound_volume / sound_max_volume * 100 ; 
		
//		eWireLog.d("EWIRE","V:" + sound_volume);
//		eWireLog.d("EWIRE","M:" + sound_max_volume);
//		eWireLog.d("EWIRE","C:" + volume);
		
		// sometimes : AudioFinger could not create track
		ToneGenerator toneGenerator = new ToneGenerator(AudioManager.STREAM_SYSTEM, (int)volume);
		toneGenerator.startTone(ToneGenerator.TONE_PROP_BEEP);
	}
}
