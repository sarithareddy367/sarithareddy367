from flask import Flask, request, jsonify
import repository_manager
import analysis_engine
from flask_cors import CORS
import git
git.refresh()


app = Flask(__name__)

CORS(app, resources={r"/analyze": {"origins": "http://127.0.0.1:5500", "methods": ["GET", "POST"]}, r"/results": {"origins": "http://127.0.0.1:5500"}})


@app.route('/analyze', methods=['POST'])
def analyze_code():
    repo_url = request.json['repo_url']
    print("URL parsed:", repo_url)

    code_path = repository_manager.clone_repo(repo_url)
    print("URL received by repo manager:", code_path)
    print("Fetching repository clone...")

    analysis_results = analysis_engine.run_analysis(code_path)
    print("Running analysis...")

    return jsonify({"analysis_results": analysis_results, "log": "Repository analyzed."})

from flask import send_from_directory

@app.route('/results')
def results():
    directory = r"E:\Fall 2023\CIS 635\Group Project"
    filename = "analysis_results.txt"
    return send_from_directory(directory, filename)


if __name__ == '__main__':
    app.run(debug=True)
