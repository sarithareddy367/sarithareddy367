import os
from pydub import AudioSegment
import transcription_utils
import pydub
# Provide the path to ffmpeg executable explicitly
pydub.AudioSegment.ffmpeg = "C:/Users/lokas/AppData/Local/Programs/ffmpeg/bin/ffmpeg.exe"

context = ""

def save_file(audio_file):
    filename = audio_file.filename
    uploads_dir = os.path.join(os.getcwd(), 'uploads')
    if not os.path.exists(uploads_dir):
        os.makedirs(uploads_dir)
    path = os.path.join(uploads_dir, filename)
    audio_file.save(path)
    return path

def transcribe_gcs(file_path, language_code="en-US"):
    # Convert the file to .wav format if necessary
    audio = AudioSegment.from_file(file_path).set_channels(1).set_sample_width(2)
    converted_path = file_path
    if not file_path.endswith('.wav'):
        converted_path = file_path.rsplit('.', 1)[0] + '.wav'
        audio.export(converted_path, format='wav')

    # Parameters for splitting the audio
    clip_length = 59 * 1000  # 59 seconds in milliseconds
    transcripts = []

    # Split the audio and transcribe each segment
    for i in range(0, len(audio), clip_length):
        clip_path = f"clip_{i}.wav"
        audio[i:i+clip_length].export(clip_path, format="wav")
        
        # Transcribe the segment
        transcript = transcription_utils.transcribe_audio(clip_path, language_code)
        if transcript:
            transcripts.extend(transcript)

        # Delete the temporary .wav file
        os.remove(clip_path)

    return transcripts
