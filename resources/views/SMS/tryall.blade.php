<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SMS Test - YOTSSSSSS</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
        }

        .icon-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .icon-container i {
            color: #fff;
            font-size: 36px;
        }

        h1 {
            color: #1a1a2e;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #444;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
            outline: none;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .action-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            margin-top: 10px;
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }

        .action-button:active {
            transform: translateY(0);
        }

        .action-button:disabled {
            background: #cccccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .message {
            margin-top: 20px;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 14px;
            display: none;
        }

        .message.success {
            background-color: #e6f7e6;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
            display: block;
        }

        .message.error {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
            display: block;
        }

        .back-link {
            display: inline-block;
            margin-top: 25px;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            text-align: center;
            width: 100%;
        }

        .back-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .back-link i {
            margin-right: 5px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 40px 20px;
            }

            h1 {
                font-size: 24px;
            }

            .action-button {
                padding: 15px 40px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon-container">
            <i class="fas fa-sms"></i>
        </div>
        <h1>Test SMS Sending</h1>
        
        <form id="smsForm">
            @csrf
            <div class="form-group">
                <label for="phone">Phone Number (with country code, e.g., 639123456789)</label>
                <input type="text" id="phone" name="phone" placeholder="e.g., 639123456789" required>
            </div>
            
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" placeholder="Enter your message here...">This is a test message from YOTSSSSSS</textarea>
            </div>
            
            <button type="submit" class="action-button" id="sendButton">
                <span class="button-text">Send SMS</span>
                <span class="button-loader" style="display: none;">
                    <i class="fas fa-spinner fa-spin"></i> Sending...
                </span>
            </button>
            
            <div id="messageContainer" class="message" style="display: none;"></div>
        </form>
        
        <a href="{{ route('home') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('smsForm');
            const sendButton = document.getElementById('sendButton');
            const messageContainer = document.getElementById('messageContainer');
            
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const phone = document.getElementById('phone').value.trim();
                const message = document.getElementById('message').value.trim();
                const buttonText = sendButton.querySelector('.button-text');
                const buttonLoader = sendButton.querySelector('.button-loader');
                
                // Validate phone number
                if (!phone) {
                    showMessage('Please enter a phone number', 'error');
                    return;
                }
                
                // Show loading state
                sendButton.disabled = true;
                buttonText.style.display = 'none';
                buttonLoader.style.display = 'inline-block';
                messageContainer.style.display = 'none';
                
                try {
                    const response = await fetch('{{ route("sms.test") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            phone: phone,
                            message: message
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        showMessage('SMS sent successfully!', 'success');
                        form.reset();
                    } else {
                        showMessage('Failed to send SMS: ' + (data.message || 'Unknown error'), 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showMessage('An error occurred. Please try again.', 'error');
                } finally {
                    // Reset button state
                    sendButton.disabled = false;
                    buttonText.style.display = 'inline-block';
                    buttonLoader.style.display = 'none';
                }
            });
            
            function showMessage(message, type) {
                messageContainer.textContent = message;
                messageContainer.className = 'message ' + type;
                messageContainer.style.display = 'block';
                
                // Scroll to message
                messageContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                
                // Add haptic feedback on mobile
                if ('vibrate' in navigator) {
                    navigator.vibrate(type === 'success' ? 50 : [100, 50, 100]);
                }
            }
            
            // Add input validation
            const phoneInput = document.getElementById('phone');
            phoneInput.addEventListener('input', function(e) {
                // Allow only numbers and + at the start
                this.value = this.value.replace(/[^0-9+]/g, '');
                
                // If + is not at the start, remove all + and add to start
                if (this.value.includes('+') && !this.value.startsWith('+')) {
                    const numbers = this.value.replace(/\D/g, '');
                    this.value = '+' + numbers;
                }
            });
        });
    </script>
</body>
</html>
