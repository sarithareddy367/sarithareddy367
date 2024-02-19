import os
import shutil
from git import Repo
import git
git.refresh()

TEMP_FOLDER = 'temp_repos'

def clone_repo(repo_url):
    print("Cloning repository...")
    if not os.path.exists(TEMP_FOLDER):
        os.makedirs(TEMP_FOLDER)
    repo_name = repo_url.split('/')[-1]
    local_path = os.path.join(TEMP_FOLDER, repo_name)
    
    if os.path.exists(local_path):
        shutil.rmtree(local_path)
    print("its working")
    repo = Repo.clone_from(repo_url, local_path)
    print("is the error here?")
    
    print("Only .py files exist")
    return local_path

def cleanup_repo(path):
    if os.path.exists(path):
        shutil.rmtree(path)
