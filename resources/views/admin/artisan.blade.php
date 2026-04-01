<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Artisan Command Runner</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            background: #1e1e1e;
            color: #d4d4d4;
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        h1 {
            color: #4CAF50;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }
        textarea {
            width: 100%;
            padding: 12px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            background: #2d2d2d;
            color: #d4d4d4;
            border: 1px solid #444;
            border-radius: 4px;
            margin: 10px 0;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            background: #2d2d2d;
            color: #d4d4d4;
            border: 1px solid #444;
            border-radius: 4px;
            margin: 10px 0;
        }
        button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            margin: 10px 5px;
        }
        button:hover {
            background: #45a049;
        }
        button.danger {
            background: #dc3545;
        }
        button.danger:hover {
            background: #c82333;
        }
        .output {
            background: #000;
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            white-space: pre-wrap;
            max-height: 500px;
            overflow-y: auto;
            border: 1px solid #333;
        }
        .example {
            background: #2d2d2d;
            padding: 10px;
            margin: 10px 0;
            border-left: 3px solid #4CAF50;
            font-size: 12px;
        }
        .example code {
            color: #ffc107;
        }
        .quick-buttons {
            margin: 20px 0;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .loading {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #4CAF50;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 8px;
            vertical-align: middle;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .success { color: #4CAF50; }
        .error { color: #dc3545; }
        hr { border-color: #444; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Artisan Command Runner</h1>
        
        <div style="background: #2d2d2d; padding: 15px; border-radius: 4px; margin: 15px 0;">
            <strong>⚠️ DEV MODE ONLY</strong> - No restrictions. Any command will run.
        </div>
        
        <div class="example">
            <strong>📝 Examples:</strong><br>
            <code>optimize:clear</code><br>
            <code>migrate:fresh</code><br>
            <code>migrate:fresh --seed</code><br>
            <code>db:seed</code><br>
            <code>cache:clear</code><br>
            <code>view:clear</code><br>
            <code>config:clear</code><br>
            <code>route:clear</code><br>
            <code>sitemap:generate</code><br>
            <code>test:ping</code><br>
        </div>
        
        <div class="quick-buttons">
            <button onclick="runThis('optimize:clear')">🧹 Clear All Caches</button>
            <button onclick="runThis('cache:clear')">🗑️ Clear Cache</button>
            <button onclick="runThis('view:clear')">👁️ Clear Views</button>
            <button onclick="runThis('config:clear')">⚙️ Clear Config</button>
            <button onclick="runThis('route:clear')">🛣️ Clear Routes</button>
            <button onclick="runThis('sitemap:generate')">🗺️ Generate Sitemap</button>
            <button onclick="runThis('test:ping')">📡 Ping Search Engines</button>
            <button class="danger" onclick="runThis('migrate:fresh')">💀 Fresh Migrate</button>
            <button class="danger" onclick="runThis('migrate:fresh --seed')">💀🌱 Fresh + Seed</button>
            <button onclick="runThis('db:seed')">🌱 Seed Database</button>
        </div>
        
        <hr>
        
        <label for="command"><strong>Enter Artisan Command:</strong></label>
        <input type="text" id="command" placeholder="e.g., optimize:clear" value="optimize:clear">
        
        <div style="margin-top: 10px;">
            <button onclick="runCommand()">▶️ RUN COMMAND</button>
            <button onclick="clearOutput()">🗑️ Clear Output</button>
        </div>
        
        <div id="output" class="output">
            Ready. Enter a command above.
        </div>
    </div>
    
    <script>
        function runCommand() {
            const command = document.getElementById('command').value.trim();
            if (!command) {
                alert('Please enter a command');
                return;
            }
            runThis(command);
        }
        
        async function runThis(command) {
            const outputDiv = document.getElementById('output');
            outputDiv.innerHTML = `<span class="loading"></span> Running: ${command}...\n\nThis may take a moment...`;
            
            try {
                const response = await fetch('/admin/command-run', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({ command: command })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    outputDiv.innerHTML = `<span class="success">✅ SUCCESS</span>\n\nCommand: ${data.command}\n\n${data.output}`;
                } else {
                    outputDiv.innerHTML = `<span class="error">❌ ERROR</span>\n\nCommand: ${command}\n\n${data.error || data.message || 'Command failed'}`;
                }
            } catch (error) {
                outputDiv.innerHTML = `<span class="error">❌ NETWORK ERROR</span>\n\n${error.message}`;
            }
        }
        
        function clearOutput() {
            document.getElementById('output').innerHTML = 'Output cleared. Enter a command.';
            document.getElementById('command').value = '';
        }
        
        // Run on Enter key
        document.getElementById('command').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                runCommand();
            }
        });
    </script>
</body>
</html>