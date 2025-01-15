<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex" style="height: 90vh;">
                    <!-- Users List -->
                    <div class="w-64 border-r border-gray-200">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-4">Chats</h3>
                            @foreach($users as $user)
                                <div 
                                    onclick="startChat({{ $user->id }}, '{{ $user->name }}')"
                                    class="py-2 cursor-pointer"
                                >
                                    <div class="font-medium">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">Click to chat</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Chat Area -->
                    <div class="flex-1 flex flex-col">
                        <div id="no-chat-selected" class="h-full flex items-center justify-center text-gray-500">
                            Select a chat to start messaging
                        </div>

                        <div id="chat-container" class="h-full hidden flex flex-col">
                            <!-- Chat Header -->
                            <div class="p-4 border-b">
                                <span id="chat-user-name" class="font-medium"></span>
                            </div>

                            <!-- Messages Area -->
                            <div id="messages" class="flex-1 overflow-y-auto p-4">
                                <!-- Messages will appear here -->
                            </div>

                            <!-- Message Input -->
                            <div class="p-4 border-t">
                                <form id="message-form" class="flex gap-2">
                                    @csrf
                                    <input type="hidden" id="selected-user" name="receiver_id" value="">
                                    <input 
                                        type="text" 
                                        name="message" 
                                        class="flex-1 rounded-full border-gray-300" 
                                        placeholder="Type your message..."
                                        required
                                    >
                                    <button 
                                        type="submit"
                                        class="bg-blue-500 text-white px-6 py-2 rounded-full"
                                    >
                                        Send
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentChatUser = null;

        function startChat(userId, userName) {
            currentChatUser = userId;
            document.getElementById('selected-user').value = userId;
            document.getElementById('chat-user-name').textContent = userName;
            document.getElementById('no-chat-selected').classList.add('hidden');
            document.getElementById('chat-container').classList.remove('hidden');
            loadMessages(userId);
        }

        function loadMessages(userId) {
            fetch(`/chat/messages/${userId}`)
                .then(res => res.json())
                .then(messages => {
                    const messagesDiv = document.getElementById('messages');
                    messagesDiv.innerHTML = '';
                    
                    messages.forEach(message => {
                        const isCurrentUser = message.sender_id === {{ auth()->id() }};
                        const messageHtml = `
                            <div class="mb-4 ${isCurrentUser ? 'text-right' : 'text-left'}">
                                <div class="inline-block">
                                    <div class="${isCurrentUser ? 'bg-blue-500 text-white' : 'bg-gray-100'} px-4 py-2 rounded-lg text-left">
                                        ${message.message}
                                    </div>
                                    ${isCurrentUser ? `
                                        <div class="text-[10px] mt-1 text-gray-400 text-right">
                                            <button onclick="editMessage(${message.id}, '${message.message.replace(/'/g, "\\'")}')" class="hover:text-gray-600">✎</button>
                                            <span class="mx-1">•</span>
                                            <button onclick="deleteMessage(${message.id})" class="hover:text-gray-600">🗑</button>
                                        </div>
                                    ` : ''}
                                </div>
                            </div>
                        `;
                        messagesDiv.innerHTML += messageHtml;
                    });
                    
                    messagesDiv.scrollTop = messagesDiv.scrollHeight;
                });
        }

        function editMessage(messageId, currentText) {
            const newText = prompt('Edit message:', currentText);
            
            if (newText && newText !== currentText) {
                fetch(`/chat/messages/${messageId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ message: newText })
                })
                .then(res => res.json())
                .then(() => {
                    loadMessages(currentChatUser);
                });
            }
        }

        function deleteMessage(messageId) {
            if (confirm('Are you sure you want to delete this message?')) {
                fetch(`/chat/messages/${messageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(res => res.json())
                .then(() => {
                    loadMessages(currentChatUser);
                });
            }
        }

        document.getElementById('message-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    receiver_id: currentChatUser,
                    message: formData.get('message')
                })
            })
            .then(res => res.json())
            .then(() => {
                this.reset();
                loadMessages(currentChatUser);
            });
        });
    </script>
</x-app-layout> 