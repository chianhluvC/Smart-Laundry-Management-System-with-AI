<html>
<head>
    <title>AI Quản Lý Phòng Trọ</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 20px; }
        #chat_container { width: 60%; margin: auto; border: 1px solid #ddd; padding: 10px; border-radius: 5px; }
        #chat_output { width: 100%; height: 300px; border: 1px solid #ccc; overflow-y: auto; padding: 5px; background: #f9f9f9; }
        input, button { margin-top: 10px; padding: 10px; width: 80%; }
        button { width: 18%; background-color: #007bff; color: white; border: none; }
    </style>
    <script>
        function sendMessage() {
            const input = document.getElementById("user_input").value;
            const chatOutput = document.getElementById("chat_output");
            chatOutput.innerHTML += "<p><strong>Bạn:</strong> " + input + "</p>";
            
            const socket = new WebSocket("ws://localhost:8080");
            socket.onopen = () => socket.send(input);
            socket.onmessage = (event) => {
                chatOutput.innerHTML += "<p><strong>AI:</strong> " + event.data + "</p>";
                chatOutput.scrollTop = chatOutput.scrollHeight;
            };
        }
    </script>
</head>
<body>
    <h1>AI Quản Lý Phòng Trọ</h1>
    <div id="chat_container">
        <div id="chat_output"></div>
        <input type="text" id="user_input" placeholder="Nhập tin nhắn...">
        <button onclick="sendMessage()">Gửi</button>
    </div>
</body>
</html>