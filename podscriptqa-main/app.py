from flask import Flask, request, jsonify
import transcription
import openai_integration
from flask_cors import CORS
from pydub import AudioSegment
import pydub
# Provide the path to ffmpeg executable explicitly
pydub.AudioSegment.ffmpeg = "C:/Users/lokas/AppData/Local/Programs/ffmpeg/bin/ffmpeg.exe"

app = Flask(__name__)
# Configure CORS
cors_config = {
    "resources": {
        r"/upload": {
            "origins": ["http://127.0.0.1:5500", "http://localhost:5500"],  # Allowed origins for /upload
            "methods": ["POST"]  # Allow only POST method
        },
        r"/ask": {
            "origins": ["http://127.0.0.1:5500", "http://localhost:5500"],  # Allowed origins for /ask
            "methods": ["POST"]  # Allow only POST method
        }
    }
}
CORS(app, **cors_config)

@app.route('/upload', methods=['POST'])
def upload_file():
    
        audio_file = request.files['file']
        file_path = transcription.save_file(audio_file)
        print(f"File saved at {file_path}")

        transcripts = transcription.transcribe_gcs(file_path)
        print(f"Transcription results: {transcripts}")

        if transcripts:
            transcription.context = " ".join(transcripts)
            print("Transcription completed")
            return jsonify({"message": "File uploaded and transcribed", "transcript": transcription.context})
        else:
            print("Transcription failed")
            return jsonify({"message": "Transcription failed"}), 500
    


@app.route('/ask', methods=['POST'])
def ask_question():
    try:
        question = request.json.get('question')
        print(f"Received question: {question}")
        answer = openai_integration.answer_question_with_gpt(transcription.context, question)
        print(f"Received answer: {answer}")
        return jsonify({"answer": answer})
    except Exception as e:
        print(f"Error during Q&A processing: {e}")
        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
    print("Starting Flask server...")
    app.run(debug=True)
