import subprocess
import os

def run_analysis(code_path):
    results = {}
    for root, dirs, files in os.walk(code_path):
        print("Analyzing code at:", code_path)
        for file in files:
            if file.endswith('.py'):
                file_path = os.path.join(root, file)
                process = subprocess.Popen(['pylint', file_path], stdout=subprocess.PIPE, stderr=subprocess.PIPE)
                stdout, stderr = process.communicate()
                results[file_path] = stdout.decode('utf-8') + stderr.decode('utf-8')

    # Save results to a text file
    with open('analysis_results.txt', 'w') as result_file:
        for file_path, analysis_result in results.items():
            result_file.write(f"Analysis for {file_path}:\n")
            result_file.write(analysis_result)
            result_file.write("\n\n")  # Add a couple of newlines for separation between files

    return results
