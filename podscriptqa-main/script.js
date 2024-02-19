document.getElementById('uploadBtn').addEventListener('click', function() {
    console.log("Upload button clicked");
    document.getElementById('podcastUpload').click();
});

document.getElementById('podcastUpload').addEventListener('change', function() {
    console.log("File selected");

    var file = this.files[0];
    console.log("Selected file:", file);

    var formData = new FormData();
    formData.append('file', file);

    fetch('http://127.0.0.1:5000/upload', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log("Received response from /upload");
        if (response.ok && response.headers.get("Content-Type").includes("application/json")) {
            return response.json();
        } else {
            throw new Error('Server returned non-JSON response');
        }
    })
    .then(data => {
        console.log("Upload and transcription successful", data);
        document.getElementById('transcriptionStatus').textContent = 'Transcription status: Complete';
    })
    .catch(error => {
        console.error('Error during upload:', error);
        document.getElementById('transcriptionStatus').textContent = 'Transcription status: Failed';
    });
});

document.getElementById('sendBtn').addEventListener('click', function() {
    var chatInput = document.getElementById('chatInput');
    var message = chatInput.value;
    chatInput.value = '';

    console.log("Sending message:", message);

    var chatWindow = document.getElementById('chatWindow');
    chatWindow.innerHTML += `<div class="user-message">User: ${message}</div>`;

    fetch('http://127.0.0.1:5000/ask', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ question: message })
    })
    .then(response => {
        console.log("Received response from /ask");
        if (response.ok && response.headers.get("Content-Type").includes("application/json")) {
            return response.json();
        } else {
            throw new Error('Server returned non-JSON response');
        }
    })
    .then(data => {
        console.log("Received answer:", data);
        chatWindow.innerHTML += `<div class="ai-message">AI: ${data.answer}</div>`;
        chatWindow.scrollTop = chatWindow.scrollHeight;
    })
    .catch(error => {
        console.error('Error during Q&A:', error);
    });
});
