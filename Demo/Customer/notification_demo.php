<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Push Notification Demo</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 1.1em;
        }
        
        .content {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        input, textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        
        textarea {
            height: 100px;
            resize: vertical;
        }
        
        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            background: #f8f9fa;
            border-left: 4px solid #667eea;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔔 Send Message</h1>
        </div>
        
        <div class="content">
            <form id="notificationForm">
                <div class="form-group">
                    <label for="user">Username:</label>
                    <input type="text" id="user" name="user" required>
                    <small>Enter username to send notification to</small>
                </div>
                
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" value="Hello from PHP!" required>
                </div>
                
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" required>This is a test notification sent from our PHP API!</textarea>
                </div>
                
                <button type="submit" class="btn">Send Notification</button>
            </form>
            
            <div id="result" class="result" style="display: none;"></div>
        </div>
    </div>

    <script>
        document.getElementById('notificationForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = {
        user: formData.get('user'),  // CHANGED: 'topic' to 'user'
        title: formData.get('title'),
        message: formData.get('message'),
    };
    
    try {
        const response = await fetch('notification_api.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        showResult(result);
    } catch (error) {
        showResult({success: false, error: error.message});
    }
});
        
        function showResult(result) {
            const resultDiv = document.getElementById('result');
            resultDiv.style.display = 'block';
            
            if (result.success) {
                resultDiv.innerHTML = `
                    <h4 style="color: green;">✅ Notification Sent!</h4>
                    <p><strong>Sent to user:</strong> ${result.topic || result.user}</p>
                    <p><a href="${result.url}" target="_blank">View Notification</a></p>
                `;
            } else {
                resultDiv.innerHTML = `
                    <h4 style="color: red;">❌ Failed to Send</h4>
                    <p><strong>Error:</strong> ${result.error}</p>
                `;
            }
        }

        // Generate random username on page load
        window.addEventListener('load', function() {
            const randomId = Math.random().toString(36).substring(2, 8);
            document.getElementById('user').value = 'user-' + randomId;
        });
    </script>
</body>
</html>