<!-- ================= AI CHATBOT UI ================= -->
<div id="ai-chat-launcher" onclick="toggleAIChat()">
  <i class="fas fa-robot"></i>
</div>

<div id="ai-chat-window" style="display: none;">
  <div class="ai-chat-header">
    <span><i class="fas fa-magic"></i> edu.io AI Tutor</span>
    <button onclick="toggleAIChat()">&times;</button>
  </div>
  <div id="ai-chat-body">
    <div class="ai-message bot">
      Halo! Saya Tutor AI edu.io. Ada yang bisa saya bantu terkait koding
      atau materi hari ini?
    </div>
  </div>
  <div class="ai-chat-footer">
    <input type="text" id="ai-input" placeholder="Tanyakan sesuatu..." autocomplete="off" />
    <button onclick="sendToAI()"><i class="fas fa-paper-plane"></i></button>
  </div>
</div>
