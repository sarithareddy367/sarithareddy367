document.getElementById('retrieveBtn').addEventListener('click', function() {
    const repoUrl = document.getElementById('repoUrl').value;
    if (repoUrl) {
        fetch('http://127.0.0.1:5000/analyze', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ repo_url: repoUrl })
        })
        .then(() => {
            // Display the results button after the POST request is completed
            document.getElementById('resultsBtn').style.display = 'block';
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
});

document.getElementById('resultsBtn').addEventListener('click', function() {
    fetch('http://127.0.0.1:5000/results')
    .then(response => response.text())
    .then(text => {
        document.getElementById('reportSection').innerText = text;
    })
    .catch(error => {
        console.error('Error fetching results:', error);
    });
});

